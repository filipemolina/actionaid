<?php
function removerCaracter($string) {
    $string = ereg_replace("[áàâãª]","a",$string);
    $string = ereg_replace("[ÁÀÂÃ]","A",$string);
    $string = ereg_replace("[éèê]","e",$string);
    $string = ereg_replace("[ÉÈÊ]","E",$string);
    $string = ereg_replace("[íì]","i",$string);
    $string = ereg_replace("[ÍÌ]","I",$string);
    $string = ereg_replace("[óòôõº]","o",$string);
    $string = ereg_replace("[ÓÒÔÕ]","O",$string);
    $string = ereg_replace("[úùû]","u",$string);
    $string = ereg_replace("[ÚÙÛ]","U",$string);
    $string = ereg_replace("ç","c",$string);
    $string = ereg_replace("Ç","C",$string);
    $string = ereg_replace("[][><}{)(:;,!?*%~^`&#@]","",$string);
    $string = ereg_replace(" ","_",$string);

    return $string;
}

function htmToBd($str) {
    $str = str_replace('&', '&amp;', $str);
    $str = str_replace('\'', '&#039;', $str);
    $str = str_replace('"', '&quot;', $str);
    $str = str_replace('<', '&lt;', $str);
    $str = str_replace('>', '&gt;', $str);
    return $str;
}

function bdToHtm($str) {
    $str = str_replace('&amp;', '&', $str);
    $str = str_replace('&#039;', '\'', $str);
    $str = str_replace('&quot;', '"', $str);
    $str = str_replace('&lt;', '<', $str);
    $str = str_replace('&gt;', '>', $str);
    //    $str = str_replace ( chr(10), "<BR/>", $str );
    return $str;
}

function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var => $val) {
            $output[$var] = sanitize($val);
        }
    } else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input = cleanInput($input);
        $input = RemoveXSS($input);
        $output = mysql_real_escape_string($input);
    }
    return $output;
}

function cleanInput($input) {
    $search = array('@<script[^>]*?>.*?</script>@si', // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'
    // Strip multi-line comments
    );
    $output = preg_replace($search, '', $input);
    return $output;
}

function RemoveXSS($val) {
    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
    // this prevents some character re-spacing such as <java\0script>
    // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
    //$val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
    $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x19])/', '', $val);
    // straight replacements, the user should never need these since they're normal characters
    // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A &#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search.= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search.= '1234567890!@#$%^&*()';
    $search.= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0;$i < strlen($search);$i++) {
        // ;? matches the ;, which is optional
        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
        // &#x0040 @ search for the hex values
        $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
        // &#00064 @ 0{0,7} matches '0' zero to seven times
        $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
        
    }
    // now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);
    $found = true; // keep replacing as long as the previous round replaced something
    while ($found == true) {
        $val_before = $val;
        for ($i = 0;$i < sizeof($ra);$i++) {
            $pattern = '/';
            for ($j = 0;$j < strlen($ra[$i]);$j++) {
                if ($j > 0) {
                    $pattern.= '(';
                    $pattern.= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern.= '|';
                    $pattern.= '|(&#0{0,8}([9|10|13]);)';
                    $pattern.= ')*';
                }
                $pattern.= $ra[$i][$j];
            }
            $pattern.= '/i';
            $replacement = substr($ra[$i], 0, 2) . '--' . substr($ra[$i], 2); // add in <> to nerf the tag
            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
            if ($val_before == $val) {
                // no replacements were made, so exit the loop
                $found = false;
            }
        }
    }
    return $val;
}
?>