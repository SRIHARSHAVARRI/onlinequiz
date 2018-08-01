	<?php
session_start();

if(!isset($_SESSION['var'])){

}
?>
	

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css"></link>
<link href="quizz.css" type="text/css" rel="stylesheet">
<style>
div#test{ border:#000 1px solid; padding:10px 40px 40px 40px; }
div#test1{ border:#000 1px solid; padding:10px 40px 40px 40px; }
.button1{
	margin: 10px;
    background-color: green;
	 padding: 10px 20px;
}
.button2{
	margin: 10px;
    background-color: red;
	 padding: 10px 20px;
}
.button3{
	margin: 10px;
    background-color: purple;
	 padding: 10px 20px;
}
.pal{
	margin: 10px;
	 padding: 10px 20px;
}

</style>
<script>

			
var pos = 0,na,overall,test1,temp=1, test, test_status, question, choice, choices, chA, chB, chC, correct = 0,test11=0,colour=0,nosub=0,wrong=0;
//2dimensional array which consists of question,optionA,optionB,optionC,correctoption;
var questions = [
    [ "Which is a reserved word in the Java programming language?", "method", "native", "subclasses", "B" ],
	[ "Which is a valid keyword in java?", "interface", "string", "Float", "A" ],
	[ "Which is the valid declarations within an interface definition?", "public double methoda();", "public final double methoda();", "static void methoda(double d1);", "A" ],
	[ "Which one is a valid declaration of a boolean?", "boolean b3 = false;", "boolean b2 = 'false';", "boolean b4 = Boolean.false();", "A" ],
	[ "What does HTML stand for?","Home Tool Markup Language","Hyperlinks and Text Markup language","Hyper Text Markup Language","C"],
	[ "Look at the following selector: $('div').What does...","The first div element","All div elements","The last div element","A"],
	[ "Where is the correct place to insert a JavaScript?","The head section","The body section","Both the head section and the body section","A"],
	[ "How do you create a function in JavaScript?","function myFunction()",'function:myFunction()','function = myFunction()','A'],
	[ "Which class provides a responsive fixed width cont...",".container",".container-fixed",".container-fluid","A"],
	[ "What does CSS stand for?","Cascading super sheet","none of these","Cascading style sheet","C"]	
	];
//array::ids for 10 buttons which are used for color changing mark for review,save and next.(green,red,purple)
var palette=['one','two','three','four','five','six','seven','eight','nine','ten'];
//for radio button checked even when we click on that question button again
var tick=['F','F','F','F','F','F','F','F','F','F'];
//like flag for every question
var radiocheck=[0,0,0,0,0,0,0,0,0,0];
var cnt=[0,0,0,0,0,0,0,0,0,0];
//1 test case when click on markforreview button and again click on saveand next button for calculating correct ,wrong ,attempted
var purpletogreen=[0,0,0,0,0,0,0,0,0,0];
var radcnt=['F','F','F','F','F','F','F','F','F','F'];
function _(x){
	return document.getElementById(x);
}
//main calling of function
function renderQuestion(){
	//css middle big box
	test = _("test");
	//css side big box
	test1 = _("test1");
	if(pos >= questions.length){
		overall = correct+wrong;
		na = questions.length-overall;
		test.innerHTML = "<h1><?php echo $_SESSION['var'];?> !!You got "+correct+" of "+questions.length+" questions correct</h1>";
		_("test_status").innerHTML ="Test Completed  RESULTS:   Attempted  :   "+overall+"  Wrong  : "+wrong+"  Not Attempted  :"+na;
		
		//pos = 0;
		//correct = 0;
		//test11=0;
		return false;
	}
	//initial top display of questions
	_("test_status").innerHTML = "Question "+(pos+1)+" of "+questions.length;
	
	question = questions[pos][0];
	chA = questions[pos][1];
	chB = questions[pos][2];
	chC = questions[pos][3];
//main big box in which the questions and its options are displayed.
	test.innerHTML = "<h1>"+question+"</h1>";
//for radio button checked oncliked on it if it is option A
if(radiocheck[pos]==1 && tick[pos]=='A'){	
test.innerHTML += "<input type='radio' name='choices' value='A' id='opa' checked > "+chA+"<br>";
test.innerHTML += "<input type='radio' name='choices' value='B' id='opb'> "+chB+"<br>";
test.innerHTML += "<input type='radio' name='choices' value='C' id='opc'>  "+chC+"<br><br>";


}
//for radio button checked onclicked on it if it is option B
if(radiocheck[pos]==1 && tick[pos]=='B'){	
test.innerHTML += "<input type='radio' name='choices' value='A' id='opa' > "+chA+"<br>";
test.innerHTML += "<input type='radio' name='choices' value='B' id='opb' checked > "+chB+"<br>";
test.innerHTML += "<input type='radio' name='choices' value='C' id='opc'>  "+chC+"<br><br>";
}
//for radio button checked onclicked on it if it is option C
if(radiocheck[pos]==1 && tick[pos]=='C'){
	test.innerHTML += "<input type='radio' name='choices' value='A' id='opa' > "+chB+"<br>";
	test.innerHTML += "<input type='radio' name='choices' value='B' id='opb' > "+chB+"<br>";	
	test.innerHTML += "<input type='radio' name='choices' value='C' id='opc' checked >"+chC+"<br><br>";}
	
//for new radio button to be clicked 	
if(radiocheck[pos]==0 && tick[pos]=='F'){
test.innerHTML += "<input type='radio' name='choices' value='A' id='opa' onclick='chck()'> "+chA+"<br>";
test.innerHTML += "<input type='radio' name='choices' value='B' id='opb' onclick='chck()'> "+chB+"<br>";
test.innerHTML += "<input type='radio' name='choices' value='C' id='opc' onclick='chck()'>  "+chC+"<br><br>";}
		if(pos<questions.length-1){	
		test.innerHTML += "&nbsp &nbsp &nbsp<button onclick='mark()'>Mark For Review & Next</button>";}
	//if we come to 10th question remaining buttons wont work.so we have to recheck all questions before going to 10th question.
	if(pos==questions.length-1){
		
		test.innerHTML += "&nbsp &nbsp &nbsp<button id='submit' onclick='checkAnswer()'>Submit</button>&nbsp &nbsp &nbsp";
								nosub=1;
		
	}
	
	if(pos<questions.length-1){
			test.innerHTML += "&nbsp &nbsp &nbsp<button onclick='checkAnswer()'>Save&Next</button>&nbsp &nbsp &nbsp";
			
	}
	

	if(test11==0){
		
	test1.innerHTML += "&nbsp &nbsp &nbsp<button class='pal' id='one' onclick='onequestion()'>1</button>&nbsp &nbsp &nbsp";
	test1.innerHTML += "<button class='pal' id='two' onclick='twoquestion()'>2</button>&nbsp &nbsp &nbsp";
	test1.innerHTML += "<button class='pal' id='three' onclick='threequestion()'>3</button>&nbsp &nbsp &nbsp";
	test1.innerHTML += "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<button class='pal' id='four' onclick='fourthquestion()'>4</button>";
    test1.innerHTML += "&nbsp &nbsp &nbsp<button class='pal' id='five' onclick='fivequestion()'>5</button>&nbsp &nbsp &nbsp";
	test1.innerHTML += "<button class='pal' id='six' onclick='sixquestion()'>6</button>&nbsp &nbsp &nbsp";
	test1.innerHTML += "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<button class='pal' id='seven' onclick='sevenquestion()'>7</button>&nbsp &nbsp";
	test1.innerHTML += "&nbsp <button class='pal' id='eight' onclick='eightquestion()'>8</button>&nbsp &nbsp &nbsp";
	test1.innerHTML += "<button class='pal' id='nine' onclick='ninequestion()'>9</button>&nbsp &nbsp";
	test1.innerHTML += "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<button class='pal' id='ten' onclick='tenquestion()'>10</button>&nbsp &nbsp &nbsp";
	
	}
	test11++;
	
	

}
//for radio button to be marked like flag=1 as a clue for radio button clicked 
function chck()
{
	radiocheck[pos]=1;
	
	
}
//for getting no. of correct answers,wrong answers and for coloring the button (red,green) by ids.
function checkAnswer(){
	choices = document.getElementsByName("choices");
	for(var i=0; i<choices.length; i++){
		if(choices[i].checked){
			
			choice = choices[i].value;
			tick[pos]=choices[i].value;
			radcnt[pos]=tick[pos];
			cnt[pos]++;
			colour=0;
			break;
		}
		else
		{
			//document.getElementById('red').checked =false;
			colour=1;
		}
	}
	
	
	if(colour==0){
		
		see=1;
		 document.getElementById(palette[pos]).style.backgroundColor = "green";
//various test cases for only radio button should be counted once when we click on save and next button		 
		 if(radcnt[pos]==tick[pos] && cnt[pos]==1){
		 
		 if(choice == questions[pos][4])
		 {
		correct++;
		}
		else{
		wrong++;
		}
	}
//test case for counting wrong answer when clicked on save and next button
	if(radcnt[pos]!=tick[pos] && cnt[pos]==1){
		
		if(choice == questions[pos][4])
		 {
			 wrong--;
		correct++;
		}
		else{
			correct--;
			wrong++;
		}
		
	}
	//test case for counting when clicked on mark for review latter on save and next
	if(purpletogreen[pos]==1 && radcnt[pos]==tick[pos])
	{
		if(choice == questions[pos][4])
		 {
			 correct--;
		 }
		 else
		 {
			 wrong--;
		 }
		
		
		
	}
		
	pos++;
	renderQuestion();
	}
	else
	{
		 document.getElementById(palette[pos]).style.backgroundColor = "red";
	pos++;
	renderQuestion();
	}
	
}
//mark for review purple colour along with validating results and next question by id.
function mark(){
	choices = document.getElementsByName("choices");
	
	for(var i=0; i<choices.length; i++){
		if(choices[i].checked){
			choice = choices[i].value;
			tick[pos]=choices[i].value;
			radcnt[pos]=tick[pos];
			colour=0;
			break;
		}
		else
		{
			colour=1;
		}
	}

		

	if(colour==0 ){
		see=1;
	document.getElementById(palette[pos]).style.backgroundColor = "purple";
	purpletogreen[pos]++;
	if(choice == questions[pos][4]){
		correct++;
	}
	else{
		wrong++;
	}
	
	}
	if(pos<questions.length-1){
	pos++;
	renderQuestion();
	
	}
}
//nosub variable is for no function of 10 buttons after the submitting the "submitbutton"
function onequestion()
{if(nosub!=1){
	
	
	
	pos=0;
	
	
	renderQuestion();
}
}
function twoquestion()
{	if(nosub!=1){
	pos=1;
	renderQuestion();
}
}
function threequestion()
{	if(nosub!=1){
	pos=2;
	renderQuestion();
}
}
function fourthquestion()
{	if(nosub!=1){
	pos=3;
	renderQuestion();
}
}
function fivequestion()
{if(nosub!=1){
	pos=4;
	renderQuestion();
}
}
function sixquestion()
{if(nosub!=1){
	pos=5;
	renderQuestion();
}
}
function sevenquestion()
{if(nosub!=1){
	pos=6;
	renderQuestion();
}
}
function eightquestion()
{if(nosub!=1){
	pos=7;
	renderQuestion();
}
}
function ninequestion()
{if(nosub!=1){
	pos=8;
	renderQuestion();
}
}
function tenquestion()
{if(nosub!=1){
	pos=9;
	renderQuestion();
}
}

window.addEventListener("load", renderQuestion, false);
</script>
</head>
<body style="background-image:url('white.png')">
	
      <div class="timecounter" >
			<script type="text/javascript">
			var nosub=0;
						function countDown(secs,elem){
							var test;
							test = _("test");
							overall = correct+wrong;
							na = questions.length-overall;
							var element = document.getElementById(elem);
							//var sec = (secs/60) % 10;
							var min = Math.floor(secs/60);
							var n = min.toString();
							
							//var min=secs/60;
							var sec=secs%60;
							var m=sec.toString();

							element.innerHTML = "<font color='black'><b>Time-Left </b></font>: "+n.fontcolor("red").fontsize(7)+"<font color='red'><b>min</b></font>"+m.fontcolor("red").fontsize(7)+ "<font color='red'><b> s</b></font>";
							if(sec<1)
							{
								min--;
							}
							
							if((min<1 && secs <1) || pos >= questions.length){
							clearTimeout(timer);
							nosub=1;
							element.innerHTML = '<br><br><h1 style="color:red;font-family:arial;">!! Test Completed !!</h1>';
						
							test.innerHTML = '<br><br><h1 style="color:red;font-family:arial;">!! Test Completed !!</h1>';
							test.innerHTML = "<h2><?php echo $_SESSION['var'];?> !!You got "+correct+" of "+questions.length+" questions correct</h2>";
							_("test_status").innerHTML ="Test Completed  RESULTS:   Attempted  :   "+overall+"  Wrong  : "+wrong+"  Not Attempted  :"+na;
							}
							
							secs--;
							var timer = setTimeout('countDown('+secs+',"'+elem+'")',1000);
							}
							
		
			</script>
			<div id="quiz"></div>
					<div  id="status" ></div>
					<script type="text/javascript">countDown(200,"status");
                       
                    </script>
	 </div>
    
	<div><table><tr><td>
	<h2 id="test_status"></h2>
    <div id="test"></div></td><td>	 
	<center><h1><font>QUESTION PALETTE</font></h1></center>
	
	<h2 id="test1"></h2></td></tr>
	
	</table></div><table align="right"><tr><td width="30%">
	<h3> <font color="#FAFAD2">WELCOME <?php echo $_SESSION['var'];?></font> </h3>
	<a style="text-decoration:none" href="logout.php" class="btn-login">LOG-OUT</a></td>
	<td><h1>Legend</h1>
	<button class="button1"></button> Answered
	<button class="button2"></button> Not Answered<br>
	<button class="button3"></button> Answered & Marked for Review</td></tr></table>

	
	
	
</body>
</html>