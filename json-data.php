
<?php

function displayDataCourseInfo(){

    $myData = array(
        "course" => "We have the following course : CISCO, CCNA1, CCNA2, Database, Java, PHP, MySQL, Oracal, Microsoft (Word, Excel, Powerpoint)...",
        "ccna1" => "CCNA1 price :$ 120 for two months",
        "ccna2" => "CCNA2 price :$ 180 for two months",
        "java" => "Java price :$ 280 for two months",
        "php" => "PHP price :$ 250 for two months",
        "mysql" => "MySQL price : $ 110 for per month",
        "oracal" => "Oracal price :$ 200 for one and a half of month2",
        "microsoft" => array(
            "word" => array(
                "price" => "Microsoft word price : $ 10 for per book"
            ),
            "excel" => array(
                "price" => "Microsoft excel price : $ 15 for per book"
            ),
            "power-point" => array(
                "price" => "Microsoft Power Point price :$ 8 for per book"
            ),
        ),
    );
//	return json_encode($myBio);
    return $myData;
}
//print_r(displayData());

function displayDataContact(){
    $myData = array(
        "data-contact" => "Email: huorpoeurn22@gmail.com, Phone: 0966707122, Address: Toul Kork, Sen Sok, Phnom Penh"
    );
    return $myData;
}

function displayMessageGetStarted(){
    $myData = array(
        "message-get-started" => "You can click on some courses below or type your messages to get some information about the courses."
    );
    return $myData;
}

function displayDataMessage(){

    $myData = array(
        "first-welcome-message" => "Welcome to GenEvo center, how can I help you?",
        "text-hello" => "Hello, how can I help you?"
    );
    return $myData;
}

function displayDataTemplate(){

    $myData = array(
        "url" => array(
            "php" => array(
                "url-1" => "https://cdn-images-1.medium.com/1*Vkf6A8Mb0wBoL3Fw1u0paA.jpeg",
                "url-2" => "https://cdn-images-1.medium.com/1*Vkf6A8Mb0wBoL3Fw1u0paA.jpeg"
            ),
            "java" => array(
                "url-1" => ""
            ),
            "oracal" => array(
                "url-1" => ""
            ),
        ),

        "title" => array(
            "php" => array(
                "title-1" => "PHP Course 1",
                "subtitle-1" => "After you completed this first course, you can work with database",
                "title-2" => "PHP Course 2",
                "subtitle-2" => "After you completed this first course, you can work create CRUD",
            ),
            "java" => array(
                "title-1" => "",
                "subtitle-1" => "",
                "title-2" => "",
                "subtitle-2" => "",
            ),
            "oracal" => array(
                "title-1" => "",
                "subtitle-1" => "",
                "title-2" => "",
                "subtitle-2" => "",
            ),
        ),
    );
    return $myData;
}

?>

