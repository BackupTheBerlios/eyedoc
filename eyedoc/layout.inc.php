<?php  // Id: /

/*********************************************************/
/* layout.inc.php                                        */
/* global layout functions                               */
/*********************************************************/

require("layout.cfg.php");
if ($graphs_on == 1) require("graphics.cfg.php");

/* create tag definitions */

function style_body() {
  global $font_conf;
  return "bgcolor=\"".$font_conf['bg_color']."\" text=\"".$font_conf['color']."\" link=\"".$font_conf['link_color']."\" vlink=\"".$font_conf['vlink_color']."\" alink=\"".$font_conf['alink_color']."\"";
}

function get_style($element = "font", $style = "norm") {

  $element = $element . "_conf";
  global $$element; $element = $$element;

  if ($style != "table") {
    $style_array[0] = "<font face=\"".$element['name']."\" size=\"".$element[$style]."\" color=\"".$element['color']."\">";
    $style_array[1] = "</font>";
  } else {
    $style_array = "bgcolor=\"".$element['bg_color']."\"";
  }

  return $style_array;
}

function print_meta() {

  global $charset;

  print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$charset\">\n";
  print "<meta name=\"author\" content=\"Haschke, Michael\">\n";
  print "<meta name=\"robots\" content=\"noindex, none\">\n";
}

/* header */
function print_header($no_body = 0) {

  global $doc_name;
  global $css_file;

  print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\"\n";
  print " \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n";

  print "<html>\n";
  print "<head>\n";
  print "<title>$doc_name</title>\n";
  print_meta();
  if ($css_file) {
    print "<link rel=stylesheet type=\"text/css\" href=\"$css_file\">";
  } else {
    $style_body = "marginwidth=\"0px\" marginheight=\"0px\" leftmargin=\"0px\" topmargin=\"0px\" " . style_body();
  }
  print "</head>\n";
  if ($no_body == 0) print "<body $style_body>\n";

}

function print_mainmenu ($parted = "", $css = "", $no_css = "") {

  global $menu;
  global $lang_code;

  $menu_url = array_map("make_url_menu", $menu);

  print "&nbsp;<a href=\"?c=$lang_code/".$menu_url['home']."\" $css>$no_css[0]".$menu['home']."$no_css[1]</a>\n";
  if ($parted != "") print "$parted\n";
  print "<a href=\"?c=$lang_code/".$menu_url['articles']."\" $css>$no_css[0]".$menu['articles']."$no_css[1]</a>\n";
  if ($parted != "") print "$parted\n";
  print "<a href=\"?c=$lang_code/".$menu_url['registry']."\" $css>$no_css[0]".$menu['registry']."$no_css[1]</a>\n";
  if ($parted != "") print "$parted\n";
  print "<a href=\"?c=$lang_code/".$menu_url['language']."\" $css>$no_css[0]".$menu['language']."$no_css[1]</a>\n";
  if ($parted != "") print "$parted\n";
  print "<a href=\"?c=$lang_code/".$menu_url['info']."\" $css>$no_css[0]".$menu['info']."$no_css[1]</a>&nbsp;\n";
}

function print_searchform ($css = "", $no_css = "") {

  global $menu, $submenu, $text, $button;
  global $url_graphs;
  global $button_graphs;
  global $button_graphs_width, $button_graphs_height;
  global $lang_code;

  $menu_url = array_map("make_url_menu", $menu);
  $submenu_url = array_map("make_url_menu", $submenu);

  print "&nbsp;".$menu['search']."\n";
  print "<input type=\"hidden\" name=\"c\" value=\"$lang_code/".$menu_url['search']."\">\n";
  print "<input type=\"text\" name=\"s\" size=\"20\" $css>\n";
  if ($button_graphs['search'] == "") {
    print "<input type=\"submit\" name=\"action\" value=\"".$button['search']."\" $css>\n";
  } else {
    print "<input type=\"image\" name=\"action\" value=\"".$button['search']."\" src=\"$url_graphs".$button_graphs['search']."\" width=\"$button_graphs_width\" height=\"$button_graphs_height\" border=\"0\">\n";
  }
  if ($button_graphs['search_help'] == "") {
    print "&nbsp;<a href=\"?c=$lang_code/".$menu_url['search']."/".$submenu_url['help']."\" style=\"cursor:help\" $css>$no_css[0]".$text['help']."$no_css[1]</a>&nbsp;\n";
  } else {
    print "&nbsp;<a href=\"?c=$lang_code/".$menu_url['search']."/".$submenu_url['help']."\" style=\"cursor:help\" $css><img src=\"$url_graphs".$button_graphs['search_help']."\" width=\"$button_graphs_width\" height=\"$button_graphs_height\" alt=\"".$text['help']."\" border=\"0\"></a>&nbsp;\n";
  }
}

function print_menu() {

  global $menu_conf, $submenu_conf;
  global $doc_name, $doc_logo, $url_graphs, $border_line;
  global $css_file;
  global $SCRIPT_NAME;

  $h = $doc_logo['height'];
  if ($doc_logo['height'] < 50) $h = "50px";

  $style_menu['css'] = "";
  $style_head['css'] = "";
  $style_submenu['css'] = "";
  $style_menu['conf'] = "";
  $style_head['conf'] = "";
  $style_submenu['conf'] = "";
  $style_menu['table'] = "";
  $style_submenu['table'] = "";

  if ($css_file) {
    $style_menu['css'] = "class=\"$menu_css\"";
    $style_head['css'] = "class=\"".$font_css['big']."\"";
    $style_submenu['css'] = "class=\"$submenu_css\"";
  } else {
    $style_menu['conf'] = get_style("font", "norm");
    $style_menu['table'] = get_style("menu", "table");
    $style_head['conf'] = get_style("menu", "big");
    $style_submenu['conf'] = get_style("submenu", "small");
    $style_submenu['table'] = get_style("submenu", "table");
  }

  print "<form action=\"$SCRIPT_NAME\" method=\"POST\">\n";
  print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
  print "<tr><td ".$style_menu['css']." ".$style_menu['table']." height=\"$h\" valign=\"middle\">";
  if ($doc_logo['pic'] != "") {
    print "<img src=\"" . $url_graphs .  $doc_logo['pic'] . "\" border=\"0\" width=\"".$doc_logo['width']."\" height=\"".$doc_logo['height']."\" alt=\"$doc_name\">";
  } else {
    print $style_head['conf'][0]."<b ".$style_head['css'].">&nbsp;$doc_name</b>".$style_head['conf'][1];
  }
  print "</td></tr>\n";
  print "<tr><td ".$style_menu['css']." ".$style_menu['table']." align=\"".$menu_conf['align']."\" valign=\"".$menu_conf['valign']."\">";
  print $style_menu['conf'][0]; print_mainmenu($menu_conf['seperation'],$style_menu['css'],$style_menu['conf']); print $style_menu['conf'][1];
  print "</td></tr>\n";
  if ($border_line['horizontal'] != "") print "<tr bgcolor=\"#000000\"><td colspan=\"2\"><img src=\"" . $url_graphs . $border_line['horizontal'] . "\" border=\"0\" width=\"100%\" height=\"".$border_line['thickness']."\" alt=\"\"></td></tr>\n";
  print "<tr><td ".$style_submenu['css']." ".$style_submenu['table']." align=\"".$submenu_conf['align']."\" valign=\"".$submenu_conf['valign']."\">\n";
  print $style_submenu['conf'][0]; print_searchform($style_submenu['css'],$style_submenu['conf']); print $style_submenu['conf'][1];
  print "</td></tr>\n";
  if ($border_line['horizontal'] != "") print "<tr bgcolor=\"#000000\"><td colspan=\"2\"><img src=\"" . $url_graphs . $border_line['horizontal'] . "\" border=\"0\" width=\"100%\" height=\"".$border_line['thickness']."\" alt=\"\"></td></tr>\n";
  print "</table>\n";
  print "</form>\n";
}

/* footer */
function print_footer() {

  global $footer_enabled;

  if ($footer_enabled == "1") {

    global $css_file;
    global $eyedoc_url;
    global $border_line, $url_graphs;

    $style_submenu['css'] = "";
    $style_submenu['conf'] = "";
    $style_submenu['table'] = "";

    if ($css_file) {
      $style_submenu['css'] = "class=\"$submenu_css\"";
    } else {
      $style_submenu['conf'] = get_style("submenu", "small");
      $style_submenu['table'] = get_style("submenu", "table");
    }

    print "<br>\n";
    print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    if ($border_line['horizontal'] != "") print "<tr bgcolor=\"#000000\"><td colspan=\"2\"><img src=\"" . $url_graphs . $border_line['horizontal'] . "\" border=\"0\" width=\"100%\" height=\"".$border_line['thickness']."\" alt=\"\"></td></tr>\n";
    print "<tr><td ".$style_submenu['css']." ".$style_submenu['table']." align=\"center\" valign=\"middle\">\n";
    print "<a href=\"$eyedoc_url\" target=\"_eyedoc\" ".$style_submenu['css'].">" . $style_submenu['conf'][0] . "powered by eyeDOC" . $style_submenu['conf'][1] . "</a>\n";
    print "</td></tr>\n";
    if ($border_line['horizontal'] != "") print "<tr bgcolor=\"#000000\"><td colspan=\"2\"><img src=\"" . $url_graphs . $border_line['horizontal'] . "\" border=\"0\" width=\"100%\" height=\"".$border_line['thickness']."\" alt=\"\"></td></tr>\n";
    print "</table>\n";
  }

  print "</body>\n";
  print "</html>\n";
}

function print_language_menu() {

  global $HTTP_REFERER;
  global $name_language, $lang_code;
  global $content_width, $css_file, $font_css;
  global $button;
  global $SCRIPT_NAME;

  $style_content['css'] = "";
  $style_content['conf'] = "";

  ksort($name_language); reset($name_language);
  $z = 2;
  $table_field[0] = ""; $table_field[1] = ""; $table_field[2] = "";

  if ($css_file) {
    $style_content['css'] = "class=" . $font_css['norm'];
  } else {
    $style_content['conf'] = get_style("font", "norm");
  }

  while ($language = each($name_language)) {
    if ($z == 2) { $z = 0; } else { $z++; }
    $table_field[$z] = $table_field[$z] . "<input type=\"radio\" name=\"l_new\" value=\"".$language['key']."\" " . content_checked($lang_code, $language['key']) . "> ".$language['value'] . "<br>\n";
  }

  // transform extern url content to an internal format
  $c_old = NULL;
  if ($old_content = strstr($HTTP_REFERER, "?c=")) {
    $old_content = substr($old_content, 3);
    $c_old = get_intern_content($old_content);
  }

  print "<form name=\"choose_lang\" action=\"$SCRIPT_NAME\" method=\"POST\">\n";
  if ($c_old) print "<input type=\"hidden\" name=\"c_old\" value=\"$c_old\">\n";
  print "<table border=\"0\" width=\"$content_width\" align=\"center\">\n";
  print "<tr>\n";
  print "<td width=\"33%\" ".$style_content['css']." align=\"center\">" . $style_content['conf'][0] . $table_field[0] . $style_content['conf'][1] . "</td>\n";
  print "<td width=\"34%\" ".$style_content['css']." align=\"center\">" . $style_content['conf'][0] . $table_field[1] . $style_content['conf'][1] . "</td>\n";
  print "<td width=\"33%\" ".$style_content['css']." align=\"center\">" . $style_content['conf'][0] . $table_field[2] . $style_content['conf'][1] . "</td>\n";
  print "</tr>\n";
  print "<tr>\n";
  print "<td colspan=\"3\" align=\"center\"><br>".$style_content['conf'][0]."<input type=\"submit\" name=\"enter\" value=\"".$button['choose_lang']."\" ".$style_content['css'].">".$style_content['conf'][0]."</td></tr>\n";
  print "</table>\n";
  print "</form>\n";
}

function transform_line($stri = "") {

  $stri = trim($stri);
  return $stri;

} 

function print_text($file) {

  global $error;

  if (@file_exists($file)) {
    if (@is_file($file)) {
      if ($line_array = @file($file)) {
        if (@is_array($line_array)) {
          $lines = array_map("transform_line", $line_array);
          if (@is_array($lines)) {
            reset($lines);
            while ($line = each($lines)) print "<p>" . $line['value'] . "</p>\n";
          } else {
            show_message("error", "111" . $error[1]);
          }
        } else {
          show_message("error", "11" . $error[1]);
        }
      } else {
        show_message("error", "1" . $error[1]);
      }
    } else {
      show_message("error", $error[0]);
    }
  } else {
    show_message("error", $error[0]);
  }
}

// show a message [question,error,warning,info]
function show_message($type = "info", $message = "UNKNOWN") {
   
  global $graphs, $graphs_on, $url_graphs;
  global $css_file, $menu_conf, $menu_css;

  $style_content['css'] = "";
  $style_content['conf'] = "";
  $style_content['table'] = "";

  if ($css_file) {
    $style_content['css'] = "class=\"$msgbox_css\"";
  } else {
    $style_content['conf'] = get_style("msgbox", "norm");
    $style_content['table'] = get_style("msgbox", "table");
  }
   
  print "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"60%\" align=\"center\" ".$style_content['table'].">\n";
  print "<tr><td valign=\"top\" ".$style_content['css'].">";
  if ($graphs_on == 1) {
    print "<img src=\"" . $url_graphs . $graphs[$type] . "\" border=\"0\">";
  } else {
    print "temp";
  }
  print "</td><td align=\"left\" valign=\"center\" width=\"100%\">" . $style_content['conf'][0] . transform_line($message) . $style_content['conf'][1] . "</td></tr>\n";
  print "</table>\n";
}

?>