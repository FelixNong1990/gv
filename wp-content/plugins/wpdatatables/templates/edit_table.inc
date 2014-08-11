<div class="wpDataTables">
    <div id="wdtPreloadLayer" class="overlayed">
    </div>
    <div class="wrap">
	<img src="<?php echo dirname(plugin_dir_url(__FILE__)); ?>/assets/img/wpdatatables-logo.png" class="wpdatatables_logo" />
	<h2>
	    <?php echo $wpShowTitle ?>
	    <?php if (!empty($table_id)) { ?>
    	    <a href="admin.php?page=wpdatatables-administration&action=delete&table_id=<?php echo $table_id ?>" class="add-new-h2 submitdelete">Delete</a>
	    <?php } ?>
	</h2>
	<div id="message" class="updated" <?php if (empty($table_id)) { ?>style="display: none;"<?php } ?> >
	    <p>To insert the table on your page use the shortcode: <strong>[wpdatatable id=<span id="wdtScId"><?php echo $table_id ?></span>]</strong></p>
	</div>    
	<form method="post" action="<?php echo PDT_ROOT_URL ?>" id="wpDataTablesSettings">
	    <table class="form-table wpDataTables">
		<tbody>
		    <tr>
			<td colspan="2">
			    <h2>Step 1 - Data source and main settings</h2>
			    <p>Provide a data source for the data.</p>
			</td>
		    </tr>        
		    <tr>
			<td colspan="2">
			    <h3>General setup</h3>
			</td>
		    </tr>
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wpTableTitle">Table title</label>
			</th>
			<td>
			    <input type="text" id="wpTableTitle" name="wpTableTitle" value="<?php if (!empty($table_data['title'])) echo $table_data['title'] ?>" /><br/>
			    <span class="description">If you want to display a header above your table, enter it here.</span>
			</td>
		    </tr>
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wpTableType">Table type</label>
			</th>
			<td>
			    <select name="wpTableType" id="wpTableType" class="wpDataTables">
				<option value="">Select a table type...</option>
				<option value="mysql" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'mysql') { ?>selected="selected"<?php } ?>>MySQL query</option>
				<option value="csv" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'csv') { ?>selected="selected"<?php } ?>>CSV file</option>
				<option value="xls" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'xls') { ?>selected="selected"<?php } ?>>Excel file</option>
				<option value="xml" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'xml') { ?>selected="selected"<?php } ?>>XML file</option>
				<option value="json" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'json') { ?>selected="selected"<?php } ?>>JSON file</option>
				<option value="serialized" <?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'serialized') { ?>selected="selected"<?php } ?>>Serialized PHP array</option>
			    </select><br/>
			    <span class="description">Choose a type of input source for your table.</span>
			</td>
		    </tr>
		    <tr valign="top" class="mysqlquery_row step1_row">
			<th scope="row">
			    <label for="wpMySQLQuery" class="tooltip" data-title="Enter MySQL SELECT query that will return the data for your wpDataTable. Make sure that this query works and returns data. If you are not sure what is a MySQL query please consider using Excel data source, or spend some time reading MySQL manuals.">MySQL query</label>
			</th>
			<td>
			    <textarea id="wpMySQLQuery" style="width: 300px; height: 150px"><?php if (!empty($table_data['table_type']) && $table_data['table_type'] == 'mysql') {
		echo $table_data['content'];
	    } ?></textarea><br/>
			    <span class="description">Enter the text of your MySQL query here. You can use %CURRENT_USER_ID% placeholder that will be replaced with the current user's ID on execution.</span>
			</td>
		    </tr>
		    <tr valign="top" class="inputfile_row step1_row">
			<th scope="row">
			    <label for="wpInputFile">Input file or URL</label>
			</th>
			<td>
			    <input type="text" id="wpInputFile" name="wpInputFile" value="<?php if (!empty($table_data['table_type']) && $table_data['table_type'] != 'mysql') {
		echo str_replace(ABSPATH, site_url(), $table_data['content']);
	    } ?>" />
			    <input id="wpUploadFileBtn" type="button" value="Upload file" /><br/>
			    <span class="description">Upload your file or provide the full URL here.<br/><b>For CSV or Excel input sources only uploaded files are supported</b>.</span>
			</td>
		    </tr>
		    <tr valign="top" class="table_editable_row step1_row">
			<th scope="row">
			    <label for="wpTableEditable">Front-end editing</label>
			</th>
			<td>
			    <input type="checkbox" id="wpTableEditable" name="wpTableEditable" <?php if (!empty($table_data['editable']) && ($table_data['editable'] == '1')) { ?>checked="checked"<?php } ?> />
			    <span class="description">Make table editable from the front-end.<br/><b>Works only for MySQL-based tables with server-side processing, and can only update one table on MySQL side</b>.</span>
			</td>
		    </tr>
		    <tr valign="top" class="table_mysql_name_row step1_row">
			<th scope="row">
			    <label for="wpTableMysqlName">Table MySQL name for editing</label>
			</th>
			<td>
			    <input type="text" id="wpTableMysqlName" name="wpTableMysqlName" value="<?php if (!empty($table_data['mysql_table_name'])) {
		echo $table_data['mysql_table_name'];
	    } ?>" />
			    <span class="description">Name of the MySQL table which will be used for updates from front-end.</span>
			</td>        
		    </tr>
		    <tr>
			<td colspan="2">
			    <h3>Additional settings</h3>
			</td>
		    </tr>
		    <tr valign="top" class="step1_row serverside_row">
			<th scope="row">
			    <label for="wpServerSide">Server-side processing</label>
			</th>
			<td>
			    <input type="checkbox" id="wpServerSide" <?php if (isset($table_data['server_side']) && $table_data['server_side']) { ?>checked="checked"<?php } ?> />
			    <span class="description">Server-side processing for MySQL-based tables. Required for front-end editing.</span>
			</td>
		    </tr>
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wdtResponsive">Responsive</label>
			</th>
			<td>
			    <input type="checkbox" id="wdtResponsive" <?php if (isset($table_data['responsive']) && $table_data['responsive']) { ?>checked="checked"<?php } ?> />
			    <span class="description">Check this checkbox if you would like this table to be responsive - display differently on desktops, tablets and mobiles.</span>
			</td>
		    </tr> 
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wpAdvancedFilter">Advanced filtering</label>
			</th>
			<td>
			    <input type="checkbox" id="wpAdvancedFilter" <?php if (!isset($table_data['filtering']) || $table_data['filtering']) { ?>checked="checked"<?php } ?> />
			    <span class="description">Check this checkbox if you would like to have a filter below each column.</span>
			</td>
		    </tr>        
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wpAdvancedFilterForm">Filter in form</label>
			</th>
			<td>
			    <input type="checkbox" id="wpAdvancedFilterForm" <?php if (isset($table_data['filtering_form']) && $table_data['filtering_form']) { ?>checked="checked"<?php } ?> />
			    <span class="description">Check this checkbox if you would like to have the advanced filter in a form</span>
			</td>
		    </tr>        
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wpTableTools">Table tools</label>
			</th>
			<td>
			    <input type="checkbox" id="wpTableTools" <?php if (!isset($table_data['tools']) || $table_data['tools']) { ?>checked="checked"<?php } ?> />
			    <span class="description">Check this checkbox if you would like to have the table tools (copy, save to excel, save to CSV, etc) enabled for this table.</span>
			</td>
		    </tr>
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wpSortByColumn">Enable sorting</label>
			</th>
			<td>
			    <input type="checkbox" id="wpSortByColumn" <?php if (!isset($table_data['sorting']) || $table_data['sorting']) { ?>checked="checked"<?php } ?> />
			    <span class="description">Check this checkbox if you would like to have sorting feature in your table.</span>
			</td>
		    </tr>
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wpFixedLayout">Limit table layout</label>
			</th>
			<td>
			    <input type="checkbox" id="wpFixedLayout" <?php if (isset($table_data['fixed_layout']) && $table_data['fixed_layout']) { ?>checked="checked"<?php } ?> />
			    <span class="description">Check this checkbox if you would like to limit the table's width to 100% of parent container (div).</span>
			</td>
		    </tr>
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wpWordWrap">Word wrap</label>
			</th>
			<td>
			    <input type="checkbox" id="wpWordWrap" <?php if (isset($table_data['word_wrap']) && $table_data['word_wrap']) { ?>checked="checked"<?php } ?> />
			    <span class="description">Check this checkbox if you would like words in cells to wrap and to extend row's height. Leave unchecked if you want to leave one-line row heights.</span>
			</td>
		    </tr>
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wpDisplayLength">Display length</label>
			</th>
			<td>
			    <select id="wpDisplayLength" class="wpDataTables">
				<option value="10" <?php if (!empty($table_data['display_length']) && $table_data['display_length'] == '10') { ?>selected="selected"<?php } ?>>10 entries</option>
				<option value="25" <?php if (!empty($table_data['display_length']) && $table_data['display_length'] == '25') { ?>selected="selected"<?php } ?>>25 entries</option>
				<option value="50" <?php if (!empty($table_data['display_length']) && $table_data['display_length'] == '50') { ?>selected="selected"<?php } ?>>50 entries</option>
				<option value="100" <?php if (!empty($table_data['display_length']) && $table_data['display_length'] == '100') { ?>selected="selected"<?php } ?>>100 entries</option>
				<option value="0" <?php if (!empty($table_data['display_length']) && $table_data['display_length'] == '0') { ?>selected="selected"<?php } ?>>All</option>
			    </select><br/> 
			    <span class="description">This options defines the default number of entries on the page for this table.</span>
			</td>
		    </tr>
		    <tr valign="top" class="step1_row">
			<th scope="row">
			    <label for="wpAddChart">Add a chart</label>
			</th>
			<td>
			    <select name="wpAddChart" id="wpAddChart" class="wpDataTables">
				<option value="none" <?php if (!empty($table_data['chart']) && $table_data['chart'] == 'none') { ?>selected="selected"<?php } ?>>No chart</option>
				<option value="area" <?php if (!empty($table_data['chart']) && $table_data['chart'] == 'area') { ?>selected="selected"<?php } ?>>Area chart</option>
				<option value="bar" <?php if (!empty($table_data['chart']) && $table_data['chart'] == 'bar') { ?>selected="selected"<?php } ?>>Bar chart</option>
				<option value="column" <?php if (!empty($table_data['chart']) && $table_data['chart'] == 'column') { ?>selected="selected"<?php } ?>>Column chart</option>
				<option value="line" <?php if (!empty($table_data['chart']) && $table_data['chart'] == 'line') { ?>selected="selected"<?php } ?>>Line chart</option>
				<option value="pie" <?php if (!empty($table_data['chart']) && $table_data['chart'] == 'pie') { ?>selected="selected"<?php } ?>>Pie chart</option>
			    </select><br/>
			    <span class="description">Select one of the options if you would like to render a chart for this table.</span>
			</td>
		    </tr>           
		    <tr valign="top" class="charttitle_row step1_row">
			<th scope="row">
			    <label for="wpChartTitle">Chart title</label>
			</th>
			<td>
			    <input type="text" name="wpChartTitle" id="wpChartTitle" value=" <?php if (!empty($table_data['chart_title'])) {
		echo $table_data['chart_title'];
	    } ?>" /><br/>
			    <span class="description">Enter a title if you would like to display a title above your chart.</span>
			</td>
		    </tr>           

		    <tr>
			<td colspan="2">
			    <input type="submit" name="submitStep1" id="submitStep1" class="button-primary" value="Save table">
			    <button class="button-primary previewButton" style="display: none">Preview</button>
			    <button class="button-primary closeButton">Close</button>
			</td>
		    </tr>
		    <tr class="step2_row">
			<td colspan="2">
			    <h2>Step 2 - Optional column setup</h2>
			    <p>If you want to tweak some presentational features you can change the column settings in this step, but this is not required, since default options have already been generated for you.</p>
			    <span class="description"><strong>Warning:</strong> If you change the table settings, save the table before modifying the column settings, because the column set can be changed and you may lose your changes.</span>
			</td>
		    </tr>        
		    <tr class="step2_row">
			<td colspan="2" class="columnsBlock">
			</td>
		    </tr>        
		    <tr class="step2_row">
			<td colspan="2">
			    <input type="submit" name="submitStep2" id="submitStep2" class="button-primary" value="Save columns" disabled="disabled">
			    <button class="button-primary ungroupButton">Ungroup</button>
			    <button class="button-primary previewButton" style="display: none">Preview</button>
			    <button class="button-primary closeButton">Close</button>
			</td>
		    </tr>  

	    </table>
	    <input type="hidden" id="wpDataTableId" value="<?php if (!empty($table_id)) {
		echo $table_id;
	    } ?>" />
	</form>

    </div>
</div>

<script type="text/javascript">

    var column_data = <?php if (!empty($column_data)) {
		echo json_encode($column_data);
	    } else {
		echo json_encode(array());
	    } ?>;
    var preview_called = false;

    function createColumnsBlock(columns){
	var block_html = '<table><tr class="sort_columns_block">';
	jQuery(columns).each(function(){
	    var columnPseudoId = Math.floor((Math.random()*10000)+1);
	    block_html += '<td data-column_id="'+this.id+'" data-column_key="'+this.display_header+'"><table class="column_table" rel="'+this.id+'" data-table_id="'+this.table_id+'">';
	    block_html += '<tr class="columnHeaderRow"><td colspan="2"><b>'+this.orig_header+'</b></td></tr>';
	    block_html += '<tr><td><b>Displayed header</b>:</td><td><input type="text" class="displayHeader" value="'+(this.display_header ? this.display_header : this.orig_header)+'" /></td></tr>';
	    block_html += '<tr class="editable_table_column_row"><td><b>Possible values</b>:<br/><small>Separate with "|"</small></td><td><input type="text" title="Used in advanced filterdropdown and in the editor dialog." class="possibleValues" value="'+(this.possible_values ? this.possible_values : '')+'" /></td></tr>';        
	    block_html += '<tr><td><b>Filter type</b>:</td><td><select class="filterType wpDataTables">';
	    block_html += '<option value="null" '+(this.filter_type == 'none' ? 'selected="selected"' : '' )+'>None</option>';
	    block_html += '<option value="text" '+(this.filter_type == 'text' ? 'selected="selected"' : '' )+'>Text</option>';
	    block_html += '<option value="number" '+(this.filter_type == 'number' ? 'selected="selected"' : '' )+'>Number</option>';
	    block_html += '<option value="number-range" '+(this.filter_type == 'number-range' ? 'selected="selected"' : '' )+'>Number range</option>';
	    block_html += '<option value="date-range" '+(this.filter_type == 'date-range' ? 'selected="selected"' : '' )+'>Date range</option>';
	    block_html += '<option value="select" '+(this.filter_type == 'select' ? 'selected="selected"' : '' )+'>Select box</option>';
	    block_html += '<option value="checkbox" '+(this.filter_type == 'checkbox' ? 'selected="selected"' : '' )+'>Checkbox</option>';
	    block_html += '</select></td></tr>';
	    block_html += '<tr><td><b>Column type</b>:</td><td><select class="columnType wpDataTables">';
	    block_html += '<option value="autodetect" '+(this.column_type == 'autodetect' ? 'selected="selected"' : '' )+'>autodetect</option>';
	    block_html += '<option value="string" '+(this.column_type == 'string' ? 'selected="selected"' : '' )+'>string</option>';
	    block_html += '<option value="int" '+(this.column_type == 'int' ? 'selected="selected"' : '' )+'>integer</option>';
	    block_html += '<option value="float" '+(this.column_type == 'float' ? 'selected="selected"' : '' )+'>float</option>';
	    block_html += '<option value="date" '+(this.column_type == 'date' ? 'selected="selected"' : '' )+'>date</option>';
	    block_html += '<option value="link" '+(this.column_type == 'link' ? 'selected="selected"' : '' )+'>URL link</option>';
	    block_html += '<option value="email" '+(this.column_type == 'email' ? 'selected="selected"' : '' )+'>E-mail link</option>';
	    block_html += '<option value="image" '+(this.column_type == 'image' ? 'selected="selected"' : '' )+'>Image</option>';
	    block_html += '</select></td></tr>';
	    if(jQuery('#wpTableEditable').is(':checked')){
		block_html += '<tr class="editable_table_column_row"><td><b>Editor input type</b>:</td><td><select class="inputType wpDataTables">';
		block_html += '<option value="text" '+(this.input_type == 'text' ? 'selected="selected"' : '' )+'>One-line edit</option>';
		block_html += '<option value="textarea" '+(this.input_type == 'textarea' ? 'selected="selected"' : '' )+'>Multi-line edit</option>';
		block_html += '<option value="selectbox" '+(this.input_type == 'selectbox' ? 'selected="selected"' : '' )+'>Single-value selectbox</option>';
		block_html += '<option value="multi-selectbox" '+(this.input_type == 'multi-selectbox' ? 'selected="selected"' : '' )+'>Multi-value selectbox</option>';
		block_html += '<option value="date" '+(this.input_type == 'date' ? 'selected="selected"' : '' )+'>Date</option>';
		block_html += '<option value="email" '+(this.input_type == 'email' ? 'selected="selected"' : '' )+'>E-mail link</option>';
		block_html += '<option value="link" '+(this.input_type == 'link' ? 'selected="selected"' : '' )+'>URL link</option>';
		block_html += '<option value="attachment" '+(this.input_type == 'attachment' ? 'selected="selected"' : '' )+'>Attachment</option>';
		block_html += '</select></td></tr>';
		block_html += '<tr class="editable_table_column_row"><td><b>ID column</b>:</td><td><fieldset><input type="radio" id="idColumn_'+columnPseudoId+'" name="idColumn" class="idColumn" '+(this.id_column == '1' ? 'checked="checked' : '') +'" /><label for="idColumn_'+columnPseudoId+'"></label></fieldset></td></tr>';        
	    }
	    block_html += '<tr class="responsive_table_column_row"><td><b>Hide on tablets</b></td><td><fieldset><input type="checkbox" id="hideOnTablets_'+columnPseudoId+'" class="hideOnTablets" '+(this.hide_on_tablets == '1' ? 'checked="checked"' : '')+' /><label for="hideOnTablets_'+columnPseudoId+'"></label></fieldset></td></tr>';
	    block_html += '<tr class="responsive_table_column_row"><td><b>Hide on mobiles</b></td><td><fieldset><input type="checkbox" id="hideOnMobiles_'+columnPseudoId+'" class="hideOnPhones" '+(this.hide_on_phones == '1' ? 'checked="checked"' : '')+' /><label for="hideOnMobiles_'+columnPseudoId+'"></fieldset></td></tr>';
	    block_html += '<tr class="group_row"><td><b>Group column</b>:</td><td><fieldset><input type="radio" id="groupColumn_'+columnPseudoId+'" class="groupColumn" name="groupColumn" '+(this.group_column == '1' ? 'checked="checked' : '') +'" /><label for="groupColumn_'+columnPseudoId+'"></label></fieldset></td></tr>';
	    block_html += '<tr class="sort_row"><td><b>Default sort column</b>:</td><td><fieldset><input value="1" type="radio" id="sortColumnYes_'+columnPseudoId+'" class="sortColumn" name="sortColumn" '+(this.sort_column == '1' ? 'checked="checked' : '') +'" /> <label for="sortColumnYes_'+columnPseudoId+'">Ascending</label><br/><input value="2" type="radio" id="sortColumnNo_'+columnPseudoId+'" class="sortColumn" name="sortColumn" '+(this.sort_column == '2' ? 'checked="checked' : '') +'" /> <label for="sortColumnNo_'+columnPseudoId+'">Descending</label></fieldset></td></tr>';
	    block_html += '<tr class="chart_row"><td><b>Add to chart</b>:</td><td><fieldset><input type="checkbox" id="useInchart_'+columnPseudoId+'" class="useInChart" '+(this.use_in_chart == '1' ? 'checked="checked' : '') +'" /><label for="useInchart_'+columnPseudoId+'"></label></fieldset></td></tr>';
	    block_html += '<tr class="chart_row"><td><b>Chart hor. axis</b>:</td><td><input type="radio" class="horizontalChart" name="horizontalChart" '+(this.chart_horiz_axis == '1' ? 'checked="checked' : '') +'" /></td></tr>';
	    block_html += '<tr><td><b>Column position</b>:</td><td><input type="text" class="columnPos" value="'+this.pos+'" /></td></tr>';
	    block_html += '<tr><td><b>Width</b>:</td><td><input type="text" class="columnWidth" value="'+this.width+'" title="Input width for column (in percents with % or pixels without "px"). Leave blank if you want to leave auto width" /></td></tr>';
	    block_html += '<tr><td><b>Visible</b>:</td><td><fieldset><input type="checkbox" id="colVisible_'+columnPseudoId+'" class="columnVisible" '+(this.visible != '0' ? 'checked="checked' : '') +'" /><label for="colVisible_'+columnPseudoId+'"></label></fieldset></td></tr>';
	    block_html += '</table></td>';
	});
	block_html += '</tr></table>';
	return block_html;
    }

    function applySortable(){
	jQuery('tr.sort_columns_block').sortable({
	    stop: function(){
		jQuery('tr.sort_columns_block > td').each(function(){
		    jQuery(this).find('input.columnPos').val(jQuery('tr.sort_columns_block > td').index(this));
		});
	    }
	});
    }

    jQuery(document).ready(function(){
	jQuery('#wpTableType').change(function(){
	    if(jQuery(this).val()=='mysql'){
		jQuery('tr.mysqlquery_row').show();
		jQuery('tr.inputfile_row').hide();
		jQuery('tr.serverside_row').show();
		jQuery('tr.table_editable_row').show();
	    }else if(jQuery(this).val() != ''){
		jQuery('tr.mysqlquery_row').hide();
		jQuery('tr.inputfile_row').show();
		jQuery('tr.serverside_row').hide();
		jQuery('tr.table_editable_row').hide();
		jQuery('tr.table_mysql_name_row').hide();
		jQuery('tr.editable_table_column_row').hide();
	    }else{ 
		jQuery('tr.mysqlquery_row').hide();
		jQuery('tr.inputfile_row').hide();
		jQuery('tr.serverside_row').hide();
		jQuery('tr.table_editable_row').hide();
		jQuery('tr.editable_table_column_row').hide();
		jQuery('tr.table_mysql_name_row').hide();
	    }
	});
    
	jQuery('#wpTableEditable').change(function(){
	    if(jQuery(this).is(':checked')){
		jQuery('tr.table_mysql_name_row').show();
		jQuery('tr.editable_table_column_row').show();
		jQuery('#wpServerSide').attr('checked','checked');
		jQuery('input.groupColumn').removeAttr('checked');
	    }else{
		jQuery('tr.table_mysql_name_row').hide();
		jQuery('tr.editable_table_column_row').hide();
	    }
	});
    
	jQuery('#wpServerSide').change(function(){
	    if(!jQuery(this).is(':checked')){
		jQuery('#wpTableEditable').removeAttr('checked').change();
	    }
	});
    
	jQuery('#wpTableEditable').change();
    
	jQuery('#wdtResponsive').change(function(){
	    if(jQuery(this).is(':checked')){
		jQuery('tr.responsive_table_column_row').show();
	    }else{
		jQuery('tr.responsive_table_column_row').hide();
	    }
	});

	jQuery('tr.step1_row input').change(function(){
	    jQuery('#submitStep2').attr('disabled','disabled');
	});
	jQuery('tr.step1_row textarea').change(function(){
	    jQuery('#submitStep2').attr('disabled','disabled');
	});
	jQuery('tr.step1_row select').change(function(){
	    jQuery('#submitStep2').attr('disabled','disabled');
	});

	jQuery('#wpUploadFileBtn').click(function(e) {
	    e.preventDefault();
	    e.stopImmediatePropagation();
	    formfield = 'wpInputFile';
	    tb_show('', 'media-upload.php?TB_iframe=true');
	});
    
	jQuery('#wpAddChart').change(function(){
	    if(jQuery(this).val() != 'none'){
		jQuery('tr.charttitle_row').show();
		jQuery('tr.chart_row').show();
	    }else{
		jQuery('tr.charttitle_row').hide();
		jQuery('tr.chart_row').hide();
	    }
	});

	window.send_to_editor = function(html) {
	    // adding a wrapper so jQuery could find the element
	    html = '<span>'+html+'</span>';
	    file_url = jQuery('a',html).attr('href');
	    jQuery('#wpInputFile').val(file_url);
	    tb_remove();
	}
    
	jQuery('#submitStep1').click(function(e){
	    e.preventDefault();
	    e.stopImmediatePropagation();
	    if(jQuery('#wpTableType').val()==''){
		wdtAlertDialog('Table type cannot be empty!','Error!');
		return;
	    }
	    if((jQuery('#wpMySQLQuery').val() == '')
		&& (jQuery('#wpInputFile').val() == '')){
		wdtAlertDialog('Table input data source cannot be empty!','Error!');
		return;
	    }
	    if(jQuery('#wpTableEditable').is(':checked')){
		if(jQuery('#wpTableMysqlName').val()==''){
		    wdtAlertDialog('MySQL table name for front-end editing is not set!','Error!'); 
		    return;
		}
	    }
	    // collecting table settings data
	    var data = { };
	    data.action = 'wdt_save_table';
	    data.table_title = jQuery('#wpTableTitle').val();
	    data.table_type = jQuery('#wpTableType').val();
	    if(data.table_type == 'mysql'){
		data.table_content = jQuery('#wpMySQLQuery').val();
	    }else{
		data.table_content = jQuery('#wpInputFile').val();
	    }
	    data.table_editable = jQuery('#wpTableEditable').is(':checked');
	    data.responsive = jQuery('#wdtResponsive').is(':checked');
	    data.table_mysql_name = jQuery('#wpTableMysqlName').val();
	    data.table_advanced_filtering = jQuery('#wpAdvancedFilter').is(':checked');
	    data.table_filter_form = jQuery('#wpAdvancedFilterForm').is(':checked');
	    data.table_tools = jQuery('#wpTableTools').is(':checked');
	    data.table_sorting = jQuery('#wpSortByColumn').is(':checked');
	    data.fixed_layout = jQuery('#wpFixedLayout').is(':checked');
	    data.word_wrap = jQuery('#wpWordWrap').is(':checked');
	    data.table_display_length = jQuery('#wpDisplayLength').val();
	    data.table_fixheader = false;
	    data.table_fixcolumns = 0;
	    data.table_chart = jQuery('#wpAddChart').val();
	    data.table_charttitle = jQuery('#wpChartTitle').val();
	    data.table_serverside = jQuery('#wpServerSide').is(':checked');
	    data.table_id = jQuery('#wpDataTableId').val();
	    jQuery('#wdtPreloadLayer').show();
	    jQuery.ajax({
		type: 'post',
		url: ajaxurl,
		data: data,
		dataType: 'json',
		success: function(response){
		    jQuery('#wdtPreloadLayer').hide();
		    if(response.error) {
			if(response.error.indexOf('array is empty')){
			    response.error += '<br/>';
			    response.error += 'This usually happens when the MySQL query returns an empty result. Please check the results of the query in some DB manager (e.g. PHPMyAdmin)';
			}
			wdtAlertDialog('phpDataTables reported an error: '+response.error,'Error!');
		    }else{
			jQuery('#wpDataTableId').val(response.table_id);
			jQuery('#wdtScId').html(response.table_id);
			jQuery('#message').show();
			var columns_block = createColumnsBlock(response.columns);
			jQuery('tr.step2_row').show();
			jQuery('tr.step2_row td.columnsBlock').html(columns_block);
			applySortable();
			if(jQuery('#wpAddChart').val() != 'none'){
			    jQuery('tr.chart_row').show();
			}else{
			    jQuery('tr.chart_row').hide();
			}
			jQuery('#submitStep2').removeAttr('disabled');
			jQuery('.previewButton').show();
			applySelecter();
			wdtAlertDialog('Table saved successfully!','Success!');
		    }
		},
		error: function(response){
		    var errMsg = response.responseText;
		    if(errMsg.indexOf('Allowed memory size of') != -1){
			errMsg += "<br/>";
			errMsg += "This error is usually occuring because you are trying to load file which is too large.<br/>";
			errMsh += "Please try another datasource, use a smaller file, or check the <a href='http://themes.karaliki.ru/wpdatatables/faq/'>FAQ</a> for other possible solutions.";
		    }
		    wdtAlertDialog(errMsg,'Error!');
		}
	    });
	});
    
	jQuery('#submitStep2').click(function(e){
	    e.preventDefault();
	    e.stopImmediatePropagation();
	    if(jQuery('#wpTableEditable').is(':checked')){
		if(jQuery('input.idColumn:checked').length==0){
		    wdtAlertDialog('ID column for front-end editing feature is not set!','Error!'); 
		    return;
		}
	    }
	    var data = { };
	    data.action = 'wdt_save_columns';
	    data.table_id = jQuery('#wpDataTableId').val();
	    data.columns = [];
	    jQuery('td.columnsBlock table.column_table').each(function(){
		var column = {};
		column.id = jQuery(this).attr('rel');
		column.display_header = jQuery(this).find('input.displayHeader').val();
		column.possible_values = jQuery(this).find('input.possibleValues').val();
		column.input_type = jQuery(this).find('select.inputType').val();
		column.filter_type = jQuery(this).find('select.filterType').val();
		column.column_type = jQuery(this).find('select.columnType').val();
		column.id_column = jQuery(this).find('input.idColumn').is(':checked');
		column.group_column = jQuery(this).find('input.groupColumn').is(':checked');
		column.sort_column = jQuery(this).find('input.sortColumn').is(':checked') ? jQuery(this).find('input.sortColumn:checked').val() : 0;
		column.hide_on_phones = jQuery(this).find('.hideOnPhones').is(':checked');
		column.hide_on_tablets = jQuery(this).find('.hideOnTablets').is(':checked');
		column.use_in_chart = jQuery(this).find('input.useInChart').is(':checked');
		column.chart_horiz_axis = jQuery(this).find('input.horizontalChart').is(':checked');
		column.pos = jQuery(this).find('input.columnPos').val();
		column.width = jQuery(this).find('input.columnWidth').val();
		column.visible = jQuery(this).find('input.columnVisible').is(':checked');
		data.columns.push(column);
	    });
	    jQuery('#wdtPreloadLayer').show();
	    jQuery.ajax({
		type: 'post',
		url: ajaxurl,
		data: data,
		dataType: 'json',
		success: function(response){
		    jQuery('#wdtPreloadLayer').hide();
		    if(response.error) {
			wdtAlertDialog('phpDataTables reported an error: '+response.error,'Error!');
		    }else{
			var columns_block = createColumnsBlock(response.columns);
			jQuery('tr.step2_row').show();
			jQuery('tr.step2_row td.columnsBlock').html(columns_block);
			applySortable();
			if(jQuery('#wpAddChart').val() != 'none'){
			    jQuery('tr.chart_row').show();
			}else{
			    jQuery('tr.chart_row').hide();
			}
			applySelecter();
			wdtAlertDialog('Columns saved successfully!','Success!');
		    }
		}
	    });
	});
    
	jQuery('a.submitdelete').click(function(e){
	    e.preventDefault();
	    e.stopImmediatePropagation();
	    if(confirm("Are you sure?")){
		window.location = jQuery(this).attr('href');
	    }
	})
    
	jQuery('button.closeButton').click(function(e){
	    e.preventDefault();
	    e.stopImmediatePropagation();
	    if(confirm('Are you sure? You will lose unsaved changes.')){
		window.location = 'admin.php?page=wpdatatables-administration';
	    }
	})
    
	jQuery('button.previewButton').click(function(e){
	    e.preventDefault();
	    e.stopImmediatePropagation();
	    var data = { };
	    data.action = 'wdt_get_preview';
	    data.table_id = jQuery('#wpDataTableId').val();
	    if(preview_called){ data.no_scripts = 1; }
	    jQuery('#wdtPreloadLayer').show();
	    jQuery.ajax({
		type: 'post',
		url: ajaxurl,
		data: data,
		dataType: 'html',
		success: function(response){
		    var dialog_div = '<div id="preview_dialog" title="Preview" style="display: none"></div>';
		    jQuery('body').append(dialog_div);
		    jQuery('#preview_dialog').html(response);
		    jQuery('#preview_dialog').find('.dataTables_wrapper').addClass('wpDataTables wpDataTablesWrapper');
		    jQuery('#preview_dialog').dialog({
				modal: true,
				width: 950,
				height: 700,
				buttons: {
					    'OK': function(){
						jQuery('#preview_dialog').find('table').dataTable({bDestroy: true});
						jQuery('#preview_dialog').html();
						jQuery(this).dialog('close');
						jQuery('#preview_dialog').remove();
						jQuery('.wdtFilterDialog').remove();
				    }
				},
				open: function(){
				    jQuery('#wdtPreloadLayer').hide();
				    preview_called = true;
				},
				close: function(){
				    jQuery('#preview_dialog').find('table').dataTable({bDestroy: true});
				    jQuery('#preview_dialog').html();
				    jQuery(this).dialog('close');
				    jQuery('#preview_dialog').remove();
				    jQuery('.wdtFilterDialog').remove();
				}
		    });
		}
	    });
	});
    
	jQuery('button.ungroupButton').click(function(e){
	    e.preventDefault();
	    jQuery('input.groupColumn').removeAttr('checked').parent().find('div.picker').removeClass('checked');
	});
    
	jQuery('#wpTableType').trigger('change');
    
	if(column_data.length > 0) {
	    var columns_block = createColumnsBlock(column_data);
	    jQuery('tr.step2_row').show();
	    jQuery('tr.step2_row td.columnsBlock').html(columns_block);
	    applySortable();
	    jQuery('#submitStep2').removeAttr('disabled');
	    jQuery('.previewButton').show();
	    if(jQuery('#wpAddChart').val() != 'none'){
		jQuery('tr.chart_row').show();
	    }else{
		jQuery('tr.chart_row').hide();
	    }
	}
	
	applySelecter();
    
    });
</script>
