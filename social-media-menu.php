<?php
/**
 * Plugin Name: Simple Social Media Menu
 * Plugin URI: http://landonhemsley.com
 * Description: This plugin provides a widget site owners can use to place and customize links to social profiles.
 * Version: 1.0.0
 * Author: Landon Hemsley
 * Author URI: http://landonhemsley.com
 * License: GPL2
 */

class simpleSocialMenu extends WP_Widget{
    
    private $areas = array("Facebook","Twitter","Instagram","Snapchat","Pinterest","Email");

    function __construct(){
        parent::__construct('simple-social-menu','Simple Social Media Menu',array(
            'description' => 'A simple, customizable, placable menu for your social media profiles'
        ));

        public function form($instance){

            foreach($this->areas as $area){
                if( !isset($instance[$area]) ) $instance[$area] = "";
                
?>
                <label for="<?php echo $this->get_field_id(); ?>">
                    <?php echo $instance[$area]?>
                </label>
                <input 
                    class="widefat" 
                    id="<?php echo $this->get_field_id(); ?>" 
                    name="<?php echo $this->get_field_name(); ?>" 
                    type="text" 
                    value="<?php echo $instance[$area]; ?>" 
                /> 
<?php

            }
            
        }

        public function update($new_instance){
            $toReturnInstance = array();
            foreach($this->area as $area){
                $toReturnInstance[$area] = !empty($new_instance[$area]) ) ? $new_instance[$area] : '';
                //TODO: VALIDATION ON INPUTS
            }
            return $toReturnInstance
        }

        //TODO: implement widget method (front end) ... example  http://www.wpbeginner.com/wp-tutorials/how-to-create-a-custom-wordpress-widget/

    }
}
