<?php
    echo validation_errors()."\n";
    echo form_open($this->router->class."/".$this->uri->segment(2)."/".$this->uri->segment(3), array('id' => 'metaForm', 'name' => 'metaForm', 'class' => 'hidden'))."\n";
    if ($this->session->flashdata('page') == $this->uri->segment(1)){
        echo form_input(array('id' => 'order', 'name' => 'order', 'value' => $this->session->flashdata('order')))."\n";
        echo form_input(array('id' => 'dir', 'name' => 'dir', 'value' => $this->session->flashdata('dir')))."\n";
    } else {
        echo form_input(array('id' => 'order', 'name' => 'order'))."\n";
        echo form_input(array('id' => 'dir', 'name' => 'dir'))."\n";
    }
    echo form_close()."\n";

    if($limit == 0){
        echo 'well there is nothing to do here....';
    } else {
        echo '<div class="title">'."\n".
        "\t\t\t".'<span onclick="order(this);" id="intPricesheetID" class="huge">Price-Sheet Name</span>'."\n".
        "\t\t\t".'<span class="tiny center">Edit</span>'."\n".
        "\t\t\t".'<span class="tiny center">Delete</span>'."\n".
		"\t\t\t".'<span class="tiny center">Print</span>'."\n".
        "\t\t".'</div>'."\n";
        foreach($pricesheets as $pricesheet){
            echo "\t\t".'<div class="row">'."\n";
            echo "\t\t\t".'<span class="huge">'.$pricesheet['strPricesheetName'].'</span>'."\n";
            echo "\t\t\t".'<span class="tiny center">'.anchor('pricesheets/update/'.$pricesheet['intPricesheetID'], image_asset("edit.png")).'</span>'."\n";
            echo "\t\t\t".'<span class="tiny center">'.anchor('pricesheets/destroy/'.$pricesheet['intPricesheetID'], image_asset("delete.png")).'</span>'."\n";
            echo "\t\t".'</div>'."\n";
			echo "\t\t\t".'<span class="tiny center">'.anchor('pricesheets/print/'.$pricesheet['intPricesheetID'], image_asset("print.png")).'</span>'."\n";
            echo "\t\t".'</div>'."\n";
        }
        echo '<div class="paging">'."\n";
        echo 'Page #' . (1 + $offset/$limit);
        if($offset > 0){
            $back = $offset - $limit;
            if($back < 0){
                $back = 0;
            }
            echo anchor("pricesheets/{$back}/{$limit}", 'Back', 'class="back"');
        }
        if($more){
            $next = $offset + $limit;
            echo anchor("pricesheets/{$next}/{$limit}", 'Next', 'class="next"');
        }
        echo "</div>";
    }
?>