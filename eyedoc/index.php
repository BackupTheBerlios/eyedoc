<?php  // Id: /

// define some vars
$lang_code = NULL;
$eyedoc_content = NULL;
$eyedoc_subcontent = NULL;

// create input array with GET & POST vars
$eyedoc_input = array_merge($HTTP_GET_VARS, $HTTP_POST_VARS);

// load includes and configs -- begin ---------------------

require("global.cfg.php"); // global configuration
require("global.inc.php"); // global functions
require("layout.inc.php"); // global layout functions and configuration

if (isset($eyedoc_input['l_new'])) {
  if (isset($eyedoc_input['c_old'])) {
    require("dialogue." . $eyedoc_input['l_new'] . ".inc.php");
    $eyedoc_input['c'] = $eyedoc_input['l_new'] . "/" . get_extern_content($eyedoc_input['c_old']);
  } else {
    require("dialogue." . $eyedoc_input['l_new'] . ".inc.php");
    $eyedoc_input['c'] = $eyedoc_input['l_new'] . "/" . get_extern_content("home");
  }
}

// control var eyedoc_input for language option
if (!$eyedoc_input) {
  $lang_code = get_language_from_browser();
} elseif (!$eyedoc_input['c']) {
  $lang_code = get_language_from_browser();
} else {
  $eyedoc_input_array = explode("/", $eyedoc_input['c']);
  if (file_exists("dialogue." . $eyedoc_input_array[0] . ".inc.php")) {
    if (is_file("dialogue." . $eyedoc_input_array[0] . ".inc.php")) {
      $lang_code = $eyedoc_input_array[0];
      $eyedoc_content = array_slice($eyedoc_input_array, 1);
    } else {
      $lang_code = get_language_from_browser();
    }
  } else {
    $lang_code = get_language_from_browser();
  }
}

if (!file_exists("dialogue.$lang_code.inc.php")) {
  $z = 0;
  while ((isset($doc_language[$z]))&&(!file_exists("dialogue." . $doc_language[$z] . ".inc.php"))) $z++;
  $lang_code = $doc_language[$z];
}

require("dialogue.$lang_code.inc.php"); // global dialogue flags

// load includes and configs -- end -----------------------

// get the content request -- begin -----------------------

if (!is_null($eyedoc_content)) {
  if (is_array($eyedoc_content)) {
    if ($content = check_content($eyedoc_content[0], $menu)) {
      $eyedoc_subcontent = array_slice($eyedoc_content, 1);
    } else {
      header("Location: ?c=" . $lang_code . "/" . $menu['home']);
      exit;
    }
  } else {
    header("Location: ?c=" . $lang_code . "/" . $menu['home']);
    exit;
  }
} else {
  header("Location: ?c=" . $lang_code . "/" . $menu['home']);
  exit;
}

// get the content request -- end -------------------------

if ($compressing_on = "1") {
  ob_start("ob_gzhandler");
} else {
  ob_start();
}

print_header();
print_menu();

if ($content == "language") {
  print_language_menu();
}

//show_message();
print_text("home.txt");
print $lang_code; print "\n<br>\n";
print_r(array_map("make_url_menu", $menu)); print "\n<br>\n";
print($REQUEST_METHOD); print "\n<br>\n";
print_r($HTTP_GET_VARS); print "\n<br>\n";
print_r($HTTP_POST_VARS); print "\n<br>\n";
print_r($eyedoc_content); print "\n<br>\n";
print "$HTTP_USER_AGENT"; print "\n<br>\n";
print "$HTTP_ACCEPT_LANGUAGE"; print "\n<br>\n";
print "$SCRIPT_NAME"; print "\n<br>\n";
print "$HTTP_REFERER"; print "\n<br>\n";

print_footer();

ob_end_flush();

?>