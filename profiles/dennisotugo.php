<?php

if (!defined('DB_USER')) {
	require "../../config.php";
}
try {
	$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD);
}
catch(PDOException $pe) {
	die("Could not connect to the database " . DB_DATABASE . ": " . $pe->getMessage());
}
$date_time = new DateTime('now', new DateTimezone('Africa/Lagos'));
global $conn;
if (isset($_POST['payload'])) {
	require "../answers.php";
	$question = trim($_POST['payload']);
  $password = trim($input[2]);
	function isTraining($question)
	{
		if (strpos($question, 'train:') !== false) {
			return true;
		}
		return false;
	}
	function getAnswer()
	{
		global $question;
		global $conn;
		$sql = 'SELECT * FROM chatbot WHERE question LIKE "' . $question . '"';
		$answer_data_query = $conn->query($sql);
		$answer_data_query->setFetchMode(PDO::FETCH_ASSOC);
		$answer_data_result = $answer_data_query->fetchAll();
		$answer_data_index = 0;
		if (count($answer_data_result) > 0) {
			$answer_data_index = rand(0, count($answer_data_result) - 1);
		}

		if ($answer_data_result[$answer_data_index]["answer"] == "") {
			return 'train: question # answer # password';
		}

		if (containsVariables($answer_data_result[$answer_data_index]['answer']) || containsFunctions($answer_data_result[$answer_data_index]['answer'])) {
			$answer = resolveAnswer($answer_data_result[$answer_data_index]['answer']);
			return $answer;
		}
		else {
			return $answer_data_result[$answer_data_index]['answer'];
		}
	}
	function resolveQuestionFromTraining($question)
	{
		$start = 7;
		$end = strlen($question) - strpos($question, " # ");
		$new_question = substr($question, $start, -$end);
		return $new_question;
	}

	function resolveAnswerFromTraining($question)
	{
		$start = strpos($question, " # ") + 3;
		$answer = substr($question, $start);
		return $answer;
	}

		if (isTraining($question)) {
			$answer = resolveAnswerFromTraining($question);
			$question = strtolower(resolveQuestionFromTraining($question));
			$question_data = array(
				':question' => $question,
				':answer' => $answer
			);
			$sql = 'SELECT * FROM chatbot WHERE question = "' . $question . '"';
			$question_data_query = $conn->query($sql);
			$question_data_query->setFetchMode(PDO::FETCH_ASSOC);
			$question_data_result = $question_data_query->fetch();
			$sql = 'INSERT INTO chatbot ( question, answer )
      	    VALUES ( :question, :answer );';
			$q = $conn->prepare($sql);
			$q->execute($question_data);
			echo "Now I understand. No wahala, now try me again";
			return;
		}

	function containsVariables($answer)
	{
		if (strpos($answer, "{{") !== false && strpos($answer, "}}") !== false) {
			return true;
		}

		return false;
	}

	function containsFunctions($answer)
	{
		if (strpos($answer, "((") !== false && strpos($answer, "))") !== false) {
			return true;
		}

		return false;
	}

	function resolveAnswer($answer)
	{
		if (strpos($answer, "((") == "" && strpos($answer, "((") !== 0) {
			return $answer;
		}
		else {
			$start = strpos($answer, "((") + 2;
			$end = strlen($answer) - strpos($answer, "))");
			$function_found = substr($answer, $start, -$end);
			$replacable_text = substr($answer, $start, -$end);
			$new_answer = str_replace($replacable_text, $function_found() , $answer);
			$new_answer = str_replace("((", "", $new_answer);
			$new_answer = str_replace("))", "", $new_answer);
			return resolveAnswer($new_answer);
		}
	}

	$answer = getAnswer();
	echo $answer;
	exit();
}
else {
?>

<!DOCTYPE html>
<!--
  Copyright (c) 2015, 2018, Oracle and/or its affiliates.
  The Universal Permissive License (UPL), Version 1.0
-->

<!-- ************************ IMPORTANT INFORMATION ************************************
        This blank template contains a basic web application setup with a header and sticky footer.
        It contains the Oracle JET framework and a default requireJS
        configuration file to show how JET can be setup in a common application.
        This project template can be used in conjunction with demo code from the JET
        website to test JET component behavior and interactions.

  Any CSS styling with the prefix "demo-" is for demonstration only and is not
  provided as part of the JET framework.

  Best practice patterns are provided as part of the JET website under the Samples section.

  Aria Landmark role attributes are added to the different sections of the application
  for accessibility compliance. If you change the type of content for a specific
  section from what is defined, you should also change the role value for that
  section to represent the appropriate content type.
  ***************************** IMPORTANT INFORMATION ************************************ -->
<html lang="en-us">
  <head>
    <title>Oracle JET Starter Template - Web Blank</title>
    <meta http-equiv="x-ua-compatible" content="IE=edge"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="viewport-fit=cover, initial-scale=1.0"/>
    <meta name="apple-mobile-web-app-title" content="Oracle JET">

<!-- injector:theme -->
<link rel="stylesheet" href="dennis/css/alta/5.0.0/web/alta.css" id="css" />
<!-- endinjector -->
    
  </head>
  <body>
  <div class="bot-body">
    <div class="messages-body">
      <div>
        <div class="message bot">
          <span class="content">Look alive</span>
        </div>
      </div>
	<div>
        <div class="message bot">
          <span class="content">What do you have in mind, Let's talk :) </span>
        </div>
      </div>
    </div>
    <div class="send-message-body">
      <input class="message-box" placeholder="Enter your words here..."/>
    </div>
  </div>

    
<div class="profile">
						<h1>Dennis Otugo</h1>
						<p>Human Being &nbsp;&bull;&nbsp; Cyborg &nbsp;&bull;&nbsp; Never asked for this</p>

					</div>
  <div class="bot-body">
    <div class="messages-body">
      <div>
        <div class="message bot">
          <span class="content">Look alive</span>
        </div>
      </div>
	<div>
        <div class="message bot">
          <span class="content">What do you have in mind, Let's talk :) </span>
        </div>
      </div>
    </div>
    <div class="send-message-body">
      <input class="message-box" placeholder="Enter your words here..."/>
    </div>
  </div>
    
      <style>
.profile {height: 100%;text-align: center;position: fixed;position: fixed;position: fixed;width: 50%;right: 0;background-color: #007bff}footer {display: none;padding: 0px !important}h1, h2, h3, h4, h5, h6 {color: white;text-align: center;bottom: 50%;left: 65%;position: fixed;font-family: Lato,'Helvetica Neue',Helvetica,Arial,sans-serif;font-weight: 700}p {position: fixed;bottom: 40%;left: 58%;line-height: 1.5;margin: 30px 0}.bot-body {max-width: 100% !important;position: fixed;margin: 32px auto;position: fixed;width: 100%;left: 0;bottom: 0px;height: 80%}.messages-body {overflow-y: scroll;height: 100%;background-color: #FFFFFF;color: #3A3A5E;padding: 10px;overflow: auto;width: 50%;padding-bottom: 50px;border-top-left-radius: 5px;border-top-right-radius: 5px}.messages-body > div {background-color: #FFFFFF;color: #3A3A5E;padding: 10px;overflow: auto;width: 100%;padding-bottom: 50px}.message {float: left;font-size: 16px;background-color: #007bff63;padding: 10px;display: inline-block;border-radius: 3px;position: relative;margin: 5px}.message: before {position: absolute;top: 0;content: '';width: 0;height: 0;border-style: solid}.message.bot: before {border-color: transparent #9cccff transparent transparent;border-width: 0 10px 10px 0;left: -9px}.color-change {border-radius: 5px;font-size: 20px;padding: 14px 80px;cursor: pointer;color: #fff;background-color: #00A6FF;font-size: 1.5rem;font-family: 'Roboto';font-weight: 100;border: 1px solid #fff;box-shadow: 2px 2px 5px #AFE9FF;transition-duration: 0.5s;-webkit-transition-duration: 0.5s;-moz-transition-duration: 0.5s}.color-change: hover {color: #006398;border: 1px solid #006398;box-shadow: 2px 2px 20px #AFE9FF}.message.you: before {border-width: 10px 10px 0 0;right: -9px;border-color: #edf3fd transparent transparent transparent}.message.you {float: right}.content {display: block;color: #000000}.send-message-body {border-right: solid black 3px;position: fixed;width: 50%;left: 0;bottom: 0px;box-sizing: border-box;box-shadow: 1px 1px 9px 0px rgba(1, 1, 1, 1)}.message-box {width: -webkit-fill-available;border: none;padding: 2px 4px;font-size: 18px}body {overflow: hidden;height: 100%;background: #FFFFFF !important}.container {max-width: 100% !important}.fixed-top {position: fixed !important;}
</style>
    <script type="text/javascript" src="dennis/js/libs/require/require.js"></script>
    <script type="text/javascript" src="dennis/js/main.js"></script>
        <script src="dennis/js/main.js"></script>
  </body>
</html>

<?php } 
?>
