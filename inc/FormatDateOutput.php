<?php



class FormatDateOutput
{
    public function __construct($date)
    {
        $date = new DateTime($date);
        echo $date->format('Y-m-d \@ G:i');
    }
}
?>
