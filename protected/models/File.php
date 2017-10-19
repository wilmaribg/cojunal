<?php 

class File extends CActiveRecord
{
    public $file;
    // ... other attributes
 
    public function rules()
    {
        return array(
            array('file', 'file', 'types'=>'jpg, gif, png, doc, docx, pdf, xls, xlsx', 'safe' => false),
        );
    }
}

?>