<?php
//include "includes.php"
//class post{
//    public $id;
//    public $title;
//    public $body;
//    public $author;
//    public $tags;
//    public $postDate;
//
//    public function __construct($inid = null, $intitle = null, $inbody = null, $inauthorID = null, $inpostDate = null){
//        $this->id = $inid;
//        $this->title = $intitle;
//        $this->body = $inbody;
//        $this->author = $inauthorID;
//
//        $formatedDate = explode("-",$inpostDate);
//
//        $this->postDate = $formatedDate[1] . '/'. $formatedDate[2] .'/' . $formatedDate[0];
//
//        $this->tags = "No Tag";
//
//        //tags
////        $database->query('SELECT b.id, t.id FROM blogPosts b VALUES (b.id = :id), LEFT JOIN blogPosts_tags t ON b.id = t.id');
////        $database->bind(':id', $inid);
////        $database->execute();
////        $tags = $database->resultSet();
////
////        $database->query('SELECT t.tag FROM tag t VALUES (t.id = :id)');
////        $database->bind(':id', $tags);
////        $database->execute();
////        $tagName = $database->resultSet();
////
////        while(true) {
////
////            if(sizeof($tags) > 0){
////                $this->tags = $tags;
////            }
////        }
//
//    }
//}