<?php
/**
 *
 * Plugin Name: Person Custom Taxonomy
 * Plugin URI: http://onechapteraday.fr
 * Description: This plugin allows you to describe more precisely the person you are talking about.
 * Version: 0.1
 * Author: Christelle Hilaricus
 * Author URI: http://onechapteraday.fr
 * License GPL2
 *
 */


/**
 * Adding person taxonomy
 *
 */

function add_person_taxonomy() {
  $labels = array (
    'name'                       => _x( 'Persons', 'taxonomy general name' ),
    'singular_name'              => _x( 'Person', 'taxonomy singular name' ),
    'search_items'               => __( 'Search Persons' ),
    'popular_items'              => __( 'Popular Persons' ),
    'all_items'                  => __( 'All Persons' ),
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'edit_item'                  => __( 'Edit Person' ),
    'update_item'                => __( 'Update Person' ),
    'add_new_item'               => __( 'Add New Person' ),
    'new_item_name'              => __( 'New Person Name' ),
    'separate_items_with_commas' => __( 'Separate persons with commas' ),
    'add_or_remove_items'        => __( 'Add or remove persons' ),
    'choose_from_most_used'      => __( 'Choose from the most used persons' ),
    'not_found'                  => __( 'No persons found.' ),
    'menu_name'                  => __( 'Persons' ),
  );

  $args = array (
    'hierarchical'          => false,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'person', 'with_front' => 'true' ),
  );

  register_taxonomy ('person', array('post', 'attachment'), $args);
}

add_action ('init', 'add_person_taxonomy', 0);


/**
 * Adding custom fields in person taxonomy
 *
 */

function add_new_meta_field() {
  # This will add the custom meta fields to the 'Add new term' page

  ?>
  <div class="form-field">
    <label for="term_meta[realname]"><?php _e( 'Real name' ); ?></label>
    <input type="text" name="term_meta[realname]" id="term_meta[realname]" value="">
    <p class="description"><?php _e( 'Enter the real name of the person.' ); ?></p>
  </div>

  <div class="form-field">
    <label for="term_meta[birthdate]"><?php _e( 'Birthdate' ); ?></label>
    <input type="text" name="term_meta[birthdate]" id="term_meta[birthdate]" value="">
    <p class="description"><?php _e( 'Enter a date with the format YYYY-mm-dd.' ); ?></p>
  </div>

  <div class="form-field">
    <label for="term_meta[deathdate]"><?php _e( 'Deathdate' ); ?></label>
    <input type="text" name="term_meta[deathdate]" id="term_meta[deathdate]" value="">
    <p class="description"><?php _e( 'Enter a date with the format YYYY-mm-dd.' ); ?></p>
  </div>

  <div class="form-field">
    <label for="term_meta[website]"><?php _e( 'Website' ); ?></label>
    <input type="text" name="term_meta[website]" id="term_meta[website]" value="">
    <p class="description"><?php _e( 'Enter the website of the person, if exists.' ); ?></p>
  </div>

  <div class="form-field">
    <label for="term_meta[twitter]"><?php _e( 'Twitter' ); ?></label>
    <input type="text" name="term_meta[twitter]" id="term_meta[twitter]" value="">
    <p class="description"><?php _e( 'Enter the Twitter account name of the person, only the part after the base url.' ); ?></p>
  </div>

  <div class="form-field">
    <label for="term_meta[facebook]"><?php _e( 'Facebook' ); ?></label>
    <input type="text" name="term_meta[facebook]" id="term_meta[facebook]" value="">
    <p class="description"><?php _e( 'Enter the Facebook account name of the person, only the part after the base url.' ); ?></p>
  </div>

  <div class="form-field">
    <label for="term_meta[instagram]"><?php _e( 'Instagram' ); ?></label>
    <input type="text" name="term_meta[instagram]" id="term_meta[instagram]" value="">
    <p class="description"><?php _e( 'Enter the Instagram account name of the person, only the part after the base url.' ); ?></p>
  </div>

  <div class="form-field">
    <label for="term_meta[youtube]"><?php _e( 'Youtube' ); ?></label>
    <input type="text" name="term_meta[youtube]" id="term_meta[youtube]" value="">
    <p class="description"><?php _e( 'Enter the Youtube account name of the person, only the part after the base url.' ); ?></p>
  </div>

  <div class="form-field">
    <label for="term_meta[soundcloud]"><?php _e( 'Soundcloud' ); ?></label>
    <input type="text" name="term_meta[soundcloud]" id="term_meta[soundcloud]" value="">
    <p class="description"><?php _e( 'Enter the Soundcloud account name of the person, only the part after the base url.' ); ?></p>
  </div>
  <?php

}

add_action( 'person_add_form_fields', 'add_new_meta_field', 10, 2 );


/**
 * Editing custom fields in person taxonomy
 *
 * @param object $term
 *
 */

function edit_meta_field ($term) {
  # Put the term ID into a variable
  $t_id = $term->term_id;

  # Retrieve the existing values for this meta field
  # This will return an array
  $term_meta = get_option( "taxonomy_$t_id" );

  ?>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[realname]"><?php _e( 'Real name' ); ?></label></th>
    <td>
    	<input type="text" name="term_meta[realname]" id="term_meta[realname]" value="<?php echo esc_attr( $term_meta['realname'] ) ? esc_attr( $term_meta['realname'] ) : ''; ?>">
    	<p class="description"><?php _e( 'Enter the real name of the person' ); ?></p>
    </td>
  </tr>

  <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[birthdate]"><?php _e( 'Birthdate' ); ?></label></th>
    <td>
    	<input type="text" name="term_meta[birthdate]" id="term_meta[birthdate]" value="<?php echo esc_attr( $term_meta['birthdate'] ) ? esc_attr( $term_meta['birthdate'] ) : ''; ?>">
    	<p class="description"><?php _e( 'Enter a date with the format YYYY-mm-dd' ); ?></p>
    </td>
  </tr>

  <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[deathdate]"><?php _e( 'Deathdate' ); ?></label></th>
    <td>
    	<input type="text" name="term_meta[deathdate]" id="term_meta[deathdate]" value="<?php echo esc_attr( $term_meta['deathdate'] ) ? esc_attr( $term_meta['deathdate'] ) : ''; ?>">
    	<p class="description"><?php _e( 'Enter a date with the format YYYY-mm-dd' ); ?></p>
    </td>
  </tr>

  <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[website]"><?php _e( 'Website' ); ?></label></th>
    <td>
    	<input type="text" name="term_meta[website]" id="term_meta[website]" value="<?php echo esc_attr( $term_meta['website'] ) ? esc_attr( $term_meta['website'] ) : ''; ?>">
    	<p class="description"><?php _e( 'Enter the website of the person, if exists.' ); ?></p>
    </td>
  </tr>

  <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[twitter]"><?php _e( 'Twitter' ); ?></label></th>
    <td>
    	<input type="text" name="term_meta[twitter]" id="term_meta[twitter]" value="<?php echo esc_attr( $term_meta['twitter'] ) ? esc_attr( $term_meta['twitter'] ) : ''; ?>">
    	<p class="description"><?php _e( 'Enter the Twitter account name of the person, only the part after the base url.' ); ?></p>
    </td>
  </tr>

  <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[facebook]"><?php _e( 'Facebook' ); ?></label></th>
    <td>
    	<input type="text" name="term_meta[facebook]" id="term_meta[facebook]" value="<?php echo esc_attr( $term_meta['facebook'] ) ? esc_attr( $term_meta['facebook'] ) : ''; ?>">
    	<p class="description"><?php _e( 'Enter the Facebook account name of the person, only the part after the base url.' ); ?></p>
    </td>
  </tr>

  <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[instagram]"><?php _e( 'Instagram' ); ?></label></th>
    <td>
    	<input type="text" name="term_meta[instagram]" id="term_meta[instagram]" value="<?php echo esc_attr( $term_meta['instagram'] ) ? esc_attr( $term_meta['instagram'] ) : ''; ?>">
    	<p class="description"><?php _e( 'Enter the Instagram account name of the person, only the part after the base url.' ); ?></p>
    </td>
  </tr>

  <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[youtube]"><?php _e( 'Youtube' ); ?></label></th>
    <td>
    	<input type="text" name="term_meta[youtube]" id="term_meta[youtube]" value="<?php echo esc_attr( $term_meta['youtube'] ) ? esc_attr( $term_meta['youtube'] ) : ''; ?>">
    	<p class="description"><?php _e( 'Enter the Youtube account name of the person, only the part after the base url.' ); ?></p>
    </td>
  </tr>

  <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[soundcloud]"><?php _e( 'Soundcloud' ); ?></label></th>
    <td>
    	<input type="text" name="term_meta[soundcloud]" id="term_meta[soundcloud]" value="<?php echo esc_attr( $term_meta['soundcloud'] ) ? esc_attr( $term_meta['soundcloud'] ) : ''; ?>">
    	<p class="description"><?php _e( 'Enter the Facebook account name of the person, only the part after the base url.' ); ?></p>
    </td>
  </tr>
  <?php

}

add_action( 'person_edit_form_fields', 'edit_meta_field', 10, 2 );


/**
 * Saving custom fields in person taxonomy
 *
 * @param int $term_id
 *
 */

function save_taxonomy_custom_meta ($term_id) {
  if (isset($_POST['term_meta'])) {
    $t_id = $term_id;
    $term_meta = get_option("taxonomy_$t_id");
    $cat_keys = array_keys($_POST['term_meta']);

    foreach ($cat_keys as $key) {
      if (isset($_POST['term_meta'][$key])) {
      	$term_meta[$key] = $_POST['term_meta'][$key];
      }
    }

    # Save the option array
    update_option( "taxonomy_$t_id", $term_meta );
  }
}

add_action( 'edited_person', 'save_taxonomy_custom_meta', 10, 2 );
add_action( 'create_person', 'save_taxonomy_custom_meta', 10, 2 );


/**
 * Fetching data with CURL
 *
 * @param object $url
 *
 * @return object $result
 *
 */

function fetch_curl_data($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);

  if (FALSE === $result)
    throw new Exception(curl_error($ch), curl_errno($ch));

  curl_close($ch);
  return $result;
}


/**
 * Getting term specific argument
 *
 * @param object $arg
 *
 * @return string
 *
 */

function get_person_arg ($arg) {
  $term = get_queried_object();
  return $term->$arg;
}


/**
 * Getting term specific option
 *
 * @param object $option
 *
 * @return string
 *
 */

function get_person_option ($option) {
  $person = get_queried_object();
  $id = $person->term_id;
  $term_meta = get_option( 'taxonomy_' . $id );
  return $term_meta[$option];
}


/**
 * Getting Instagram username
 *
 * @return string
 *
 */

function get_instagram_username () {
  return get_person_option('instagram');
}


/**
 * Getting Instagram link
 *
 * @return string
 *
 */

function get_instagram_link () {
  $instagram = get_instagram_username();
  if ($instagram != '') {
    $link = 'https://instagram.com/' . $instagram;
    return $link;
  }
}

/**
 * Getting Instagram pictures (max = 20)
 *
 * @param int $max
 *
 * @return array $data
 *
 */

function get_instagram_pictures ($max = 20) {
  $username = get_instagram_username();
  if ($username) {
    $result = fetch_curl_data('https://www.instagram.com/' . $username . '/media/');
    $result = json_decode($result, JSON_UNESCAPED_SLASHES);

    if ($result) {
      $data = [];
      $i = 0;

      foreach ($result['items'] as $post) {
        $link = $post['link'];
        $text = $post['caption']['text'];
        $image = $post['images']['standard_resolution']['url'];
        array_push($data, array('link' => $link, 'text' => $text, 'image' => $image));

        $i += 1;
        if ($i >= $max) {
          break;
        }
      }

      return $data;
    }
  }
}


/**
 * Create a dashboard widget with birthdays of the current month.
 */

function birthdays_dashboard_widget () {
  # Get all persons created
  $terms = get_terms(array(
    'taxonomy' => 'person',
    'hide_empty' => false,
    'fields' => 'all',
    'limit' => -1,
  ));

  #Get today's month and day
  $now = new DateTime();
  $month = date('m');
  $day = date('d');
  $results = array();

  # Retrieve all persons born this month
  foreach ($terms as $person) {
    $id = $person->term_id;
    $term_meta = get_option( 'taxonomy_' . $id );
    if ($term_meta['birthdate'] != '') {
      $birthdate = DateTime::createFromFormat('Y-m-d', $term_meta['birthdate']);
      if ($month == $birthdate->format('m')) {
        array_push($results, $person);
      }
    }
  }

  # If array has results
  $count = sizeof($results);

  if($count > 0) {
    # Sort array by day number
    uasort($results, function($a, $b) {
      $a_id = $a->term_id;
      $b_id = $b->term_id;
      $a_meta = get_option( 'taxonomy_' . $a_id );
      $b_meta = get_option( 'taxonomy_' . $b_id );
      $a_date = DateTime::createFromFormat('Y-m-d', $a_meta['birthdate']);
      $b_date = DateTime::createFromFormat('Y-m-d', $b_meta['birthdate']);
      $a_str = $a_date->format('j');
      $b_str = $b_date->format('j');

      return ($a_str < $b_str) ? -1 : 1;
    });

    # Display all persons with their birthday and age
    ?>
    <table cellspacing="0" cellpadding="3" width="100%">
      <?php
      foreach ($results as $person) {
        $id = $person->term_id;
        $name = $person->name;
        $slug = $person->slug;
        $description = $person->description;
        $link = get_term_link($person);
        # Retrieve all custom data
        $term_meta = get_option( 'taxonomy_' . $id );
        $birthdate = DateTime::createFromFormat('Y-m-d', $term_meta['birthdate']);
        $deathdate = DateTime::createFromFormat('Y-m-d', $term_meta['deathdate']);
        if ($deathdate == '') $age = $now->diff($birthdate)->y;
	else $age = $deathdate->diff($birthdate)->y;
        ?>
        <tr<?php if ($day == $birthdate->format('d')) { ?> class="highlight"<?php } ?>>
	  <td><?php echo $birthdate->format('M. j'); ?></td>
          <td>
            <a href="<?php echo $link; ?>" target="blank">
	      <?php echo $name; ?>
            </a>
          </td>
          <td><small><?php echo $age . ' years old'; ?></small></td>
          <td>
	      <small><em><?php echo 'born on ' . $birthdate->format('Y'); ?>
	      <?php if ($deathdate != '') { echo ', deceased on ' . $deathdate->format('Y'); } ?></em></small>
	  </td>
        </tr>
        <?php
      }
      ?>
    </table>
    <?php
  } else {
    echo 'There is nobody born this month among your persons.';
  }
}

function add_dashboard_widgets() {
  $now = new DateTime();
  $title = $now->format('F') . ' birthdays';
  $function = 'birthdays_dashboard_widget';
  $widget_slug = 'birthdays-dashboard-widget';

  wp_add_dashboard_widget ($widget_slug, $title, $function);
}

add_action( 'wp_dashboard_setup', 'add_dashboard_widgets' );


/**
 * Flush rewrites when the plugin is activated
 *
 */

function myplugin_flush_rewrites() {
  flush_rewrite_rules();
}

# Prevent 404 errors on persons' archive

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'myplugin_flush_rewrites' );

add_action( 'init', 'myplugin_flush_rewrites' );

?>
