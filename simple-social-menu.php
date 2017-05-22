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
    
    private $areas = array("Facebook","Twitter","LinkedIn","Email");
    private $alignments = array("center", "left", "right");
    private $sizes = array("large", "small");

    public function __construct(){
        parent::__construct('simple-social-menu','Simple Social Media Menu',array(
            'description' => 'A simple, customizable, placable menu for your social media profiles'
        ));
    }

    public function form($instance){

        foreach($this->areas as $area):
            if( !isset($instance[$area]) ) $instance[$area] = "";
            
?>
            <label for="<?php echo $this->get_field_id($area); ?>">
                <?php echo $area; ?>
            </label>
            <input 
                class="widefat" 
                id="<?php echo $this->get_field_id($area); ?>" 
                name="<?php echo $this->get_field_name($area); ?>" 
                type="text" 
                value="<?php echo $instance[$area]; ?>" 
            /> 

<?php   endforeach; 
        echo sprintf("<label for='%s'>Alignment</label> <select class='widefat' id='%s' name='%s'>",
            $this->get_field_id("alignment"),
            $this->get_field_id("alignment"),
            $this->get_field_name("alignment")
        );
        foreach($this->alignments as $value => $option){
            echo sprintf("<option value=%d %s>%s</option>",
                $value,
                $instance["alignment"] == $value ? "selected" : "",
                $option
            );
        }
        echo "</select>";

        echo sprintf("<label for='%s'>Size</label><select class='widefat' id='%s' name='%s'>",
            $this->get_field_id('size'),
            $this->get_field_id('size'),
            $this->get_field_name('size')
        );
        foreach($this->sizes as $value => $size){
            echo sprintf("<option value=%d %s>%s</option>",
                $value, 
                $instance["size"] == $value ? "selected" : "",
                $size
            );
        }
        echo '</select>';
    }

    public function update($new_instance){
        var_dump($new_instance);
        $toReturnInstance = array();
        foreach($this->areas as $area){
            $toReturnInstance[$area] = !empty($new_instance[$area]) ? $new_instance[$area] : '';
            //TODO: VALIDATION ON INPUTS
        }
        $toReturnInstance["alignment"] = $new_instance["alignment"];
        $toReturnInstance["size"] = $new_instance["size"];
        return $toReturnInstance;
    }

    public function widget($args, $instance){
        echo '<div class="social-media-menu-bin">';
            echo $args['before_widget'];
            $alignClass = 'ssm-text-' . $this->alignments[$instance['alignment']]; 
            echo "<div class='social-links $alignClass'><ul class='image-list'>";
            foreach($this->areas as $name){
                $filename = $name;
                if($instance['size'] == 1) $filename = $filename . '-sm';
                $image_path = plugin_dir_url(__FILE__) . '/img/'.$filename.'.png';
                $url = $instance[$name];
                if(!empty($url)){
                    if($name == 'Email') 
                        echo "<li><a href='mailto:$url'><img src='$image_path' alt='$name'/></a></li>";
                    else
                        echo "<li><a href='$url' target='_blank'><img src='$image_path' alt='$name'/></a></li>";
                }
            }
            echo '</ul></div>';
            echo $args['after_widget'];
        echo '</div>';
    }

    
}

function register_simpleSocialMenu(){
    register_widget('simpleSocialMenu');
}

add_action('widgets_init', 'register_simpleSocialMenu');

function register_simpleSocialMenu_styles(){
    wp_enqueue_style('simpleSocialMenuStyle', plugin_dir_url(__FILE__).'css/style.css');
}
add_action('wp_enqueue_scripts','register_simpleSocialMenu_styles');

?>
