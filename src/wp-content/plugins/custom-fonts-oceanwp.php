<?php
 /**
 * Plugin Name:     Custom Fonts for OceanWP
 * Description:     Allows you to use custom fonts in OceanWP theme
 * Author:          K.Nadobnykh
 * Text Domain:     custom-fonts-oceanwp
 * Version:         1.1.0
 */

function ocean_add_custom_fonts()
{
	if(class_exists('Bsf_Custom_Fonts_Taxonomy')) {
		$fonts = Bsf_Custom_Fonts_Taxonomy::get_fonts();
		return array_keys($fonts);
	}
}