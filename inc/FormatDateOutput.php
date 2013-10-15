<?php



class FormatDateOutput
{
    public function __construct($date, $time)
    {
        $date = new DateTime($date);
        $time_parts = explode(':', $time);
        $date_output = strval($date->format('j/m')) . ' kl. ' . $time_parts[0] . ':' . $time_parts[1];
        echo $date_output;
    }
}
?>
