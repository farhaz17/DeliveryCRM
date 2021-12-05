<?php
    function get_column_performace($performance_column_setting, $column_value)
    {
        if($performance_column_setting['profitability_indicator'] == 1){
            switch ($column_value) {
                case $column_value >= $performance_column_setting['excellent'] :
                        return "Excellent";
                case ($performance_column_setting['very_good'] <= $column_value) && ($column_value < $performance_column_setting['excellent'] ) :
                        return "Very Good";
                case ($performance_column_setting['good'] <= $column_value) && ($column_value < $performance_column_setting['very_good'] ) :
                        return "Good";
                case ($performance_column_setting['bad'] <= $column_value) && ($column_value < $performance_column_setting['good'] ) :
                        return "Bad";
                case ($column_value < $performance_column_setting['bad'] ) :
                        return "Very Bad";
            }
        }elseif($performance_column_setting['profitability_indicator'] == 2){

            switch ($column_value) {
                case   $column_value > 0  && $column_value <= $performance_column_setting['excellent']:
                        return "Excellent";
                case ( $column_value > $performance_column_setting['excellent'] ) && ($column_value <= $performance_column_setting['very_good'] ) :
                        return "Very Good";
                case ( $column_value > $performance_column_setting['very_good']) && ($column_value <= $performance_column_setting['good'] ) :
                        return "Good";
                case ($column_value > $performance_column_setting['good']) && ($column_value <= $performance_column_setting['bad'] ) :
                        return "Bad";
                case ( $column_value > $performance_column_setting['bad']) :
                        return "Very Bad";
            }
        }
    }
    function get_column_result($input, $max, $min){
        return number_format((($input - $min) * 100) / ($max - $min), 0);
    }
?>
