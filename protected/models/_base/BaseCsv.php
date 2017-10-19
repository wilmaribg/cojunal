<?php 
class BaseCsv extends CActiveRecord
{
    public $csv;
 
    public function rules()
    {
        return array(
            array('csv', 'file', 'types'=>'csv', 'safe' => false),
        );
    }
}

?>