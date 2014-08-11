jQuery(function($){
	var browser = {};
	if (navigator && navigator.appVersion){
		browser.msie6 = navigator.appVersion.indexOf('MSIE 6.0') != -1;
		browser.msie7 = navigator.appVersion.indexOf('MSIE 7.0') != -1;
		browser.msie8 = navigator.appVersion.indexOf('MSIE 8.0') != -1;
	}
	$('#window-close').tooltip({placement: 'bottom'});
	var feedbackList;
	$(document).bind('submitting#feedbackform#window.un', function(event, data){
		data.document = window.parent.document.documentElement.outerHTML;
		data.debug = window.parent.usernoise_debug;
	});
	$.extend(usernoise.window, {
		moveToDiscussion: function(id){
			$('#button-back').fadeIn(100);
			if ($('body').is('.rtl'))
				$('#viewport').animate({right: '-61.95%'}, 150);
			else
				$('#viewport').animate({left: '-61.95%'}, 150);
				
		},
		moveToCommentForm: function(id){
			moveToDiscussion(id);
		},
		moveToFeedback:function(){
			if ($('body').is('.rtl')){
				$('#viewport').animate({right: '0px'}, 150, function(){
						$('#button-back').fadeOut(100);
						$(document).trigger('movedtofeedback#window.un');
				});
			} else {
				$('#viewport').animate({left: '0px'}, 150, function(){
						$('#button-back').fadeOut(100);
						$(document).trigger('movedtofeedback#window.un');
				});
			}
		}
	});
	
	$(document).bind('itemselected#feedbacklist#window.un', function(event, id){
		usernoise.window.moveToDiscussion(id);
	});
	$('#un-feedback-wrapper, #un-thankyou').resize(function(){
		if (browser.msie8){
			$('#window').height($(this).outerHeight() - 47);
			$('#viewport').height($(this).outerHeight() - 44);
			
		} else {
			$('#window').height($(this).outerHeight());
			$('#viewport').height($(this).outerHeight());
		}
	});
	$('#window').height($('#un-feedback-wrapper').outerHeight());
	$('#viewport').height($('#window').height())
	function likeHandler(event){
		var $link = $(this);
		if ($link.attr('disabled'))
			return false;
		if (!$(this).is('a')) $link = $(this).closest('a');
		$link.parent().find('a.likes, a.dislikes').removeAttr('disabled');
		$link.attr('disabled', 'disabled');
		var action = $link.hasClass('likes') ? 'un_like' : 'un_dislike';
		$.post(pro.ajaxurl, {
			action: action,
			id: $(this).attr('href').replace('#like-', '')
		}, function(response){
			response = usernoise.helpers.parseJSON(response);
			$link.parent().find('a.likes span').text(response.likes);
			$link.parent().find('a.dislikes span').text(response.dislikes);
		});
		event.preventDefault();
		return false;
	}
	
	
	function FeedbackList($block){
		var self = this;
		var $block = $block;
		var $ajaxLoader = $('#feedback-list-loader');
		var offset = 0;
		var currentType = pro.enable_types ? pro.default_type : null;
		var end = false;
		var loading = false;
		var discussion = null;
		var $title = $block.find('h3');
		
		
		
		function loadMoreClickHandler(){
			loadItems(false);
			return false;
		}
		
		function loadItems(removeExisting){
			if (removeExisting)
				end = false;
			$ajaxLoader.show();
			loading = true;
			$block.addClass('loading');
			$.get(pro.ajaxurl, 
				{action: 'un_get_feedback', offset: (removeExisting ? '0' : $block.find('li').length), type: currentType}, function(response){
					$block.removeClass('loading');
					response = usernoise.helpers.parseJSON(response);
					if (removeExisting){
						$block.html(response.html);
					} else {
						$block.find('ul').append(response.html);
					}
					$ajaxLoader.hide();
					if (!response.end){
						bindListEvents();
					} else {
						end = true;
					}
					createOrUpdateScrollbar();
					loading = false;
			});
			return false;
		}
		
		function selectItem(item){
			var discussionHolder;
			if ($(item).is('.selected')){
				return;
			}
			$('#feedback-discussion').remove();
			$block.find('li').removeClass('selected')
			item.addClass('selected');
			$(document).trigger('itemselected#feedbacklist#window.un');
			discussionHolder = $("<div id='feedback-discussion' class='loading' />")
			discussionHolder.appendTo($('#pro'));
			discussion = new Discussion(item, discussionHolder);
		}

		function typeSelectedHandler(event, type){
			$block.html('').addClass('loading');
			currentType = type;
			loadItems(true);
		}
		
		function createOrUpdateScrollbar(){
			$('#feedback-list .viewport').css('height', ($('#window').height() - $('#feedback-list-block h3').outerHeight()) + "px");
			if ($('#feedback-list').data('tsb'))
				$('#feedback-list').tinyscrollbar_update('relative');
			else
				$('#feedback-list').tinyscrollbar();
		}

		createOrUpdateScrollbar();
		
		function bindListEvents(){
			$block.find('.likes, .dislikes').click(likeHandler);
			$block.find('li.feedback').click(function(event){
					selectItem($(this).closest('li.feedback'));
				return true;
			});
			$('#feedback-list').scroll(function(){
				var $list = $block.find('ul');
				if ( -$list.parent().position().top > $list.height() - $list.parent().parent().height() - 40){
					if (!end && !loading){
						loadItems(false);
					}
				}
			});
			$('#button-back').click(function(){
				usernoise.window.moveToFeedback();
				return false;
			});
		}
		
		bindListEvents();

		$('#window').resize(function(){
			if($(this).is(':visible')){
				createOrUpdateScrollbar();
			}
		});
		$(document).bind('typeselected#feedbackform#window.un', typeSelectedHandler);
		
		$(document).bind('movedtofeedback#window.un', function(){
			$block.find('li.feedback.selected').removeClass('selected');
		});
		loadItems(true);
	}
	
	function CommentForm($form, postId){
		var self = this;
		var $loader = $('#un-comment-loader');
		var $inputs = $form.find('*:input');
		var $name = $form.find("*[name=name]");
		var $email = $form.find('*[name=email]');
		var $comment = $form.find('*[name=comment]');
		var $loader = $form.find('i');
		var $submit = $form.find('input[type=submit]');
		$inputs.unAutoPlaceholder();
		$loader.hide();
		$inputs.focus(function(){
			$(this).tooltip('destroy');
		});
		$form.submit(submitHandler);
		function submitHandler(){
			$inputs.tooltip('destroy');
			$loader.show();
			$submit.css({opacity: 0.7}).attr('disabled', 'disabled');
			$.post(pro.ajaxurl, {action: 'un_submit_comment', 
				name: $name.val(), 
				email: $email.val(),
				comment: $comment.val(),
				post_id: postId
				}, function(response){
					response = usernoise.helpers.parseJSON(response);
					$submit.css({opacity: 1}).removeAttr('disabled');
					$loader.hide();
					if (response.success){
						$('#comment-list ul li.blank-slate').remove();
						$('#comment-list ul').append($(response.html));
						$comment.val('');
					} else {
						showErrors(response.errors);
					};
					$(document).trigger('posted#comment#usernoise');
				});
			return false;
		}
		
		function showErrors(errors){
			$inputs.tooltip('destroy');
			$.each(errors, function(index, error){
				$form.find('*:input[name="' + index + '"]').tooltip({title: error, trigger: 'manual'}).tooltip('show');
			});
		}
		
	}
	function Discussion($selected, $block){
		var self = this;
		var $commentsLoader = $block.find('.comments-loader');
		load();
		$(document).on('posted#comment#usernoise', function(){
			createOrUpdateScrollbar();
		});
		function load(){
			$.post(pro.ajaxurl, {
				action: 'un_get_discussion',
				post_id: getFeedbackId()
			}, loadedHandler)
		}
		function getFeedbackId(){
			return $selected.attr('data-id');
		}
		function loadedHandler(response){
			response = usernoise.helpers.parseJSON(response);
			$block.html(response.comments).removeClass('loading');
			updateHeight();
			new CommentForm($('#comment-form'), getFeedbackId());
			$block.find('ul li a.likes, li a.dislikes').click(likeHandler);
		}
		
		function createOrUpdateScrollbar(){
			if ($('#comment-list').data('tsb'))
				$('#comment-list').tinyscrollbar_update('relative');
			else
				$('#comment-list').tinyscrollbar();
			
		}
		function updateHeight(){
			var newHeight = ($('#window').height()) + 'px';
			$block.height(newHeight);
			$block.find('#feedback-discussion, #comment-list').height(newHeight);
			$('#comment-list .viewport').height($('#window').height() + "px");
			createOrUpdateScrollbar();
		}
		$.extend(self, {
			addComment: function(html, count){
				$commentList.find('li.blank-slate').remove();
				$commentList.append($(html));
				$listWrapper.tinyscrollbar_update('bottom');
				$countLabel.html(count);
			}
		})
	}
	if (pro.enable_discussions){
		feedbackList = new FeedbackList($('#feedback-list-block'));
	}
	

});