<?php

/**
 * Dashboard class
 *
 * @author Tareq Hasan
 * @package WP User Frontend
 */
class WPUF_Frontend_Dashboard {

    function __construct() {
        add_shortcode( 'wpuf_dashboard', array($this, 'shortcode') );
    }

    /**
     * Handle's user dashboard functionality
     *
     * Insert shortcode [wpuf_dashboard] in a page to
     * show the user dashboard
     *
     * @since 0.1
     */
    function shortcode( $atts ) {

        extract( shortcode_atts( array('post_type' => 'post'), $atts ) );

        ob_start();

        if ( is_user_logged_in() ) {
            $this->post_listing( $post_type );
        } else {
            $message = wpuf_get_option( 'un_auth_msg', 'wpuf_dashboard' );

            if ( empty( $message ) ) {
                //$msg = sprintf( __( "This page is restricted. Please %s to view this page.", 'wpuf' ), wp_loginout( '', false ) );
				$msg = sprintf( __( "This page is restricted. Please %s to view this page.", 'wpuf' ), "<a href='#' class='popup-login'>Login</a> or <a href='#' class='popup-register'>Register</a>" );
                echo apply_filters( 'wpuf_dashboard_unauth', $msg, $post_type );
            } else {
                echo $message;
            }
        }

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * List's all the posts by the user
     *
     * @global object $wpdb
     * @global object $userdata
     */
    function post_listing( $post_type ) {
        global $wpdb, $userdata, $post;

        $userdata = get_userdata( $userdata->ID );
        $pagenum = isset( $_GET['pagenum'] ) ? intval( $_GET['pagenum'] ) : 1;

        //delete post
        if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == "del" ) {
			$this->delete_post();
        }

        //show delete success message
        if ( isset( $_GET['msg'] ) && $_GET['msg'] == 'deleted' ) {
            echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' . __( 'Video Deleted', 'wpuf' ) . '</div>';
        }

        $args = array(
            'author' => get_current_user_id(),
            'post_status' => array('draft', 'future', 'pending', 'publish', 'private' ),
            'post_type' => $post_type,
            'posts_per_page' => wpuf_get_option( 'per_page', 'wpuf_dashboard', 10 ),
            'paged' => $pagenum
        );

        $original_post = $post;
        $dashboard_query = new WP_Query( apply_filters( 'wpuf_dashboard_query', $args ) );
        $post_type_obj = get_post_type_object( $post_type );
        ?>

        <h2 class="page-head">
            <span class="colour"><?php printf( __( "%s's Dashboard", 'wpuf' ), $userdata->display_name ); ?></span>
        </h2>
		<?php $post_type_obj->label = "Videos"; ?>
        <?php if ( wpuf_get_option( 'show_post_count', 'wpuf_dashboard', 'on' ) == 'on' ) { ?>
            <div class="post_count"><?php printf( __( 'You have posted <span>%d</span> %s', 'wpuf' ), $dashboard_query->found_posts, $post_type_obj->label); ?></div>
        <?php } ?>

        <?php do_action( 'wpuf_dashboard_top', $userdata->ID, $post_type_obj ) ?>

        <?php if ( $dashboard_query->have_posts() ) { ?>

            <?php
            $featured_img = wpuf_get_option( 'show_ft_image', 'wpuf_dashboard' );
            $featured_img_size = wpuf_get_option( 'ft_img_size', 'wpuf_dashboard' );
            $charging_enabled = wpuf_get_option( 'charge_posting', 'wpuf_payment' );
			?>

			<script>
				var videoNonce = "<?php echo wp_create_nonce('videoNonce'); ?>";
			</script>
			<?php
			echo do_shortcode('[wpdatatable id=1]');
            ?>
            
			
            <?php
        } else {
            printf( __( 'No %s found', 'wpuf' ), $post_type_obj->label );
            do_action( 'wpuf_dashboard_nopost', $userdata->ID, $post_type_obj );
        }

        do_action( 'wpuf_dashboard_bottom', $userdata->ID, $post_type_obj );
        ?>

        <?php
        //$this->user_info();
    }

    /**
     * Show user info on dashboard
     */
    function user_info() {
        global $userdata;

        if ( wpuf_get_option( 'show_user_bio', 'wpuf_dashboard', 'on' ) == 'on' ) {
            ?>
            <div class="wpuf-author">
                <h3><?php _e( 'Author Info', 'wpuf' ); ?></h3>
                <div class="wpuf-author-inside odd">
                    <div class="wpuf-user-image"><?php echo get_avatar( $userdata->user_email, 80 ); ?></div>
                    <div class="wpuf-author-body">
                        <p class="wpuf-user-name"><a href="<?php echo get_author_posts_url( $userdata->ID ); ?>"><?php printf( esc_attr__( '%s', 'wpuf' ), $userdata->display_name ); ?></a></p>
                        <p class="wpuf-author-info"><?php echo $userdata->description; ?></p>
                    </div>
                </div>
            </div><!-- .author -->
            <?php
        }
    }

    /**
     * Delete a post
     *
     * Only post author and editors has the capability to delete a post
     */
    function delete_post() {
        global $userdata;

        $nonce = $_REQUEST['_wpnonce'];
        //if ( !wp_verify_nonce( $nonce, 'wpuf_del' ) ) {
		if ( !wp_verify_nonce( $nonce, 'videoNonce' ) ) {
            die( "Security check" );
        }

        //check, if the requested user is the post author
        $maybe_delete = get_post( $_REQUEST['pid'] );

        if ( ($maybe_delete->post_author == $userdata->ID) || current_user_can( 'delete_others_pages' ) ) {
            wp_delete_post( $_REQUEST['pid'] );

            //redirect
            $redirect = add_query_arg( array('msg' => 'deleted'), get_permalink() );
            wp_redirect( $redirect );
        } else {
            echo '<div class="error">' . __( 'You are not the post author. Cheeting huh!', 'wpuf' ) . '</div>';
        }
    }

}