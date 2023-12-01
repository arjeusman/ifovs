<?php

require('config.php');

if(isset($_POST['use'])):
  $email = $_POST['email'];
  $check = mysqli_query($con, "select * from answers where email='$email'");
  $check = mysqli_num_rows($check);
  $check1 = mysqli_query($con, "select * from applications where email_address='$email'");
  $check1 = mysqli_num_rows($check1);
  if($check <= 0 && $check1 > 0):
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'You may start!',
      'message' => 'Your answers will be recorded using this email ('.$_POST['email'].').',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  else:
    $_SESSION['message'] = array(
      'type' => 'error',
      'title' => 'Warning!',
      'message' => 'Unable to use email address, please try again.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  endif;
  header("location: ?ref=".uniqid());
endif;

if(isset($_GET['answers'])):
  $answers = $_GET['answers'];
  $email = $_SESSION['email'];
  $date = date('F d, Y');
  $save = mysqli_query($con, "insert into answers(email, answers, date) values ('$email', '$answers', '$date')");
  if($save){
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Recorded!',
      'message' => 'Your answers was recorded successfully.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  } else {
    $_SESSION['message'] = array(
      'type' => 'error',
      'title' => 'Warning!',
      'message' => 'Failed to record your score, please try again.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  }
  header("location: questionaire.php");
endif;

if(isset($_SESSION['email'])):
  $email = $_SESSION['email'];
  $check = mysqli_query($con, "select * from answers where email='$email'");
  $check = mysqli_num_rows($check);
endif;

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Questionaire - IFOVS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"crossorigin="anonymous"/>
  <link rel="icon" href="assets/favicon.ico">
  <link rel="stylesheet" type="text/css" href="assets/bootstrap.theme.css"/>
  <link rel="stylesheet" type="text/css" href="assets/style.css"/>
  <?php include('includes/popMessage.php'); ?>
</head>
<body class="container bg-white" <?php if(isset($_SESSION['message'])): print 'onload="showMessage()"'; endif; ?>>

<div class="d-flex align-items-center justify-content-center py-4" style="min-height: 100vh;">
    <?php if(!isset($_SESSION['email'])): ?>
    <div style="max-width: 300px;">
      <a href="#">
        <img style="width: 80px;" src="assets/logo.png">
      </a>
      <div class="d-block my-4">
        <h1 class="fs-3 mt-3 mb-3">Applicant Pre Test Questions</h1>
        <div class="alert alert-info bg-gradient" role="alert">
          <div class="alert-message">
            Please enter the email address that you've used in your application.
          </div>
        </div>
        <form method="post" action="" class="needs-validation" novalidate>
          <label for="email" class="form-label">Email Address</label>
          <input class="form-control form-control-lg mb-2" type="email" id="email" name="email" autocomplete="off" required>
          <button name="use" type="submit" class="btn btn-lg btn-info bg-gradient">Continue <i class="bi-arrow-right"></i></button>
        </form>
      </div>
    </div>
    <?php else: ?>
    <div style="width: 600px">
    <a href="#">
      <img style="width: 80px;" src="assets/logo.png">
    </a>
    <?php if(isset($check) && $check > 0): ?>
      <ul class="list-group list-group-flush mt-4">
        <?php $app = getApplication($_SESSION['email']); ?>
        <li class="list-group-item p-2">
        <h1 class="fs-2 m-0">Test Result</h1>
        </li>
        <li class="list-group-item p-2"><i class="bi-person"></i> Name: <b><?php print $app['first_name'].' '.$app['last_name']; ?></b> <small class="text-muted">(in application record)</small></li>
        <li class="list-group-item p-2"><i class="bi-envelope"></i> Email : <b><?php print $_SESSION['email']; ?></b></li>
        <li class="list-group-item p-2"><i class="bi-question-circle"></i> Score : <a href="#score">View score</a></li>
      </ul>
      <?php
        $data = mysqli_query($con, "select * from answers where email='$email'");
        $data = mysqli_fetch_assoc($data);
        $answers = explode(',', $data['answers']);
        $answer_keys = file_get_contents('questionaire.json');
        $answer_keys = json_decode($answer_keys);
        $score = 0;
      ?>
      <?php foreach($answers as $index => $ans): ?>
        <?php $item = $answer_keys[$index]; ?>
        <?php $the_ans = $item->answer; ?>
        <?php $my_ans = $answers[$index]; ?>
        <?php if($my_ans == $the_ans): ?>
          <?php $score++; ?>
        <?php endif; ?>
        <div class="my-2 mt-4">
          <h1 class="fs-4 mb-2"><?php print ($index+1).'. '.$item->question; ?></h1>
          <fieldset class="d-flex flex-column gap-2">
            <?php foreach($item->choices as $c => $cc): ?>
              <?php
              if($the_ans == $c): //correct
                $class = 'correct';
              else: //wrong
                if($my_ans == $c):
                  $class = 'wrong';
                else:
                  $class = '';
                endif;
              endif;
              ?>
              <div class="choice d-flex align-items-center justify-content-start rounded-3 <?php print $class; ?>" for="<?php print $c; ?>">
                <span><?php print $cc; ?></span>
                <?php if($my_ans==$c): ?>
                  <?php if($my_ans == $the_ans): ?>
                    <i style="color: green" class="bi-check-circle ms-2"></i>
                  <?php else: ?>
                    <i style="color: red" class="bi-x-circle ms-2"></i>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </fieldset>
          <?php endforeach; ?>
          <div class="py-4" id="score">
            <span>Your score is</span>
            <br/>
            <span style="font-size: 75px;color: <?php print ($score>24)?'#2f9264':'red'; ?>" class="fw-bolder m-0"><?php print $score; ?></span>
            <sup style="font-size: 40px" class="m-0">/<?php print count($answer_keys); ?></sup>
          </div>
        </div>
    <?php else: ?>
      <div class="d-flex justify-content-between">
        <h1 class="fs-3 mt-3 mb-3">Applicant Pre Test Questions</h1>
        <div class="d-flex align-items-center gap-2 bg-success bg-opacity-25 rounded-3 shadow-lg fs-1 p-2">
          <i class="bi-clock"></i>
          <span id="time">00:00:00</span>
        </div>
      </div>
      <div class="d-block my-4">
        <h2 class="fs-5 text-muted bg-secondary bg-gradient bg-opacity-25 p-2 my-2 border-bottom border-2" id="category"></h2>
        <h1 class="fs-4 mb-2" id="question"></h1>
        <fieldset class="d-flex flex-column gap-2" id="group">
          <label class="choice rounded-3 overflow-hidden gap-2" for="a">
            <input type="radio" id="a" name="choice" value="a">
            <span id="aLabel"></span>
          </label>
          <label class="choice rounded-3 overflow-hidden gap-2" for="b">
            <input type="radio" id="b" name="choice" value="b">
            <span id="bLabel"></span>
          </label>
          <label class="choice rounded-3 overflow-hidden gap-2" for="c">
            <input type="radio" id="c" name="choice" value="c">
            <span id="cLabel"></span>
          </label>
          <label class="choice rounded-3 overflow-hidden gap-2" for="d">
            <input type="radio" id="d" name="choice" value="d">
            <span id="dLabel"></span>
          </label>
        </fieldset>
      </div>
      <button id="previous" type="button" class="btn btn-lg btn-secondary bg-gradient"><i class="bi-arrow-left"></i> Previous</button>
      <button id="next" type="button" class="btn btn-lg btn-info bg-gradient">Next <i class="bi-arrow-right"></i></button>
      <button id="submit" type="button" class="btn btn-lg btn-success bg-gradient d-none">Submit <i class="bi-arrow-right"></i></button>
    <?php endif; ?>
  </div>
  <?php endif; ?>
</div>

<style type="text/css">
  html {
    user-select: none;
  }
  fieldset .choice {
    cursor: pointer;
    display: flex;
    align-items: center;
    background: #fff;
    border: 1px solid #eee;
    transition: all linear .2s;
    min-height: 50px;
    padding: 0px;
  }
  fieldset .choice::before {
    content: attr(for) '.';
    display: block;
    font-size: 18px;
    width: 50px;
    text-align: center;
    font-weight: 500;
    text-transform: uppercase;
  }
  fieldset .choice.active {
    color: #fff;
    background: #4ca27a;
    border: 1px solid #2f9264;
  }
  fieldset .correct {
    color: green;
    border: 1px solid green;
  }
  fieldset .wrong {
    color: red;
    border: 1px solid red;
  }
  fieldset label input {
    display: none;
  }
</style>

<?php if(isset($_SESSION['email']) && $check <= 0): ?>
<script type="module">
  window.addEventListener("load", (event) => {
    let hour = 1, min = 29, sec = 59
    let time = document.getElementById('time')
    let timer = window.setInterval(function(){
      if(hour == 0 && min == 0 && sec == 0){
        window.clearInterval(timer);
        Swal.fire({
          icon: 'warning',
          title: 'Time is out',
          text: 'Your time is out, the system will now submit your answers.',
          showConfirmButton: false,
          allowOutsideClick: false,
          width: 350
        })
        window.setTimeout(function(){
          Process()
          window.location.href = '?answers='+answers.toString()
        }, 3000)
      }
      var hh, mm, ss
      (hour < 10)?hh = 0 + hour.toString():hh = hour;
      (min < 10)?mm = 0 + min.toString():mm = min;
      (sec < 10)?ss = 0 + sec.toString():ss = sec;
      time.innerHTML = hh + ':' + mm + ':' + ss
      if(sec == 0){
        sec = 59
        min--
      }
      if(min == 0 && hour > 0){
        min = 59
        hour--
      }
      if(hour == 0 && min < 30){
        var x = document.getElementById('time').parentElement
        if(x.classList.contains('bg-success')){
          x.classList.remove('bg-success')
          x.classList.add('bg-warning')
        }
      }
      if(hour == 0 && min < 10){
        var x = document.getElementById('time').parentElement
        if(x.classList.contains('bg-warning')){
          x.classList.remove('bg-warning')
          x.classList.add('bg-danger')
        }
      }
      sec--
    }, 1000)
  });
  import questionaire from './questionaire.json' assert { type: "json" }
  let answers = []
  let number = 0
  let category = document.getElementById('category')
  let question = document.getElementById('question')
  getQuestion()
  function getQuestion(){
    category.innerHTML = questionaire[number]._category
    question.innerHTML = (number+1) + '. ' + questionaire[number].question.replace(/\n/g, "<br/>")
    document.getElementById('aLabel').innerHTML = questionaire[number].choices.a
    document.getElementById('bLabel').innerHTML = questionaire[number].choices.b
    document.getElementById('cLabel').innerHTML = questionaire[number].choices.c
    document.getElementById('dLabel').innerHTML = questionaire[number].choices.d

    //previous button
    if(number > 0){
      toggleButton('previous', 'show')
    } else {
      toggleButton('previous', 'hide')
    }

    //next button
    if(number < (questionaire.length-1)){
      toggleButton('next', 'show')
    } else {
      toggleButton('next', 'hide')
    }

    //submit button
    if(number == (questionaire.length-1)){
      toggleButton('submit', 'show')
    } else {
      toggleButton('submit', 'hide')
    }

    const choices = document.querySelectorAll('input')
    Array.from(choices).forEach(choice => {
      if(answers[number] == choice.value){
        choice.parentElement.classList.add('active')
      }
    })

    console.log(answers)
  }

  function toggleButton(id, toggle){
    let button = document.getElementById(id)
    if(toggle=='show'){
      button.classList.remove('d-none')
      button.classList.add('d-inline-block')
    } else {
      button.classList.remove('d-inline-block')
      button.classList.add('d-none')
    }
  }

  //choices default state
  const choices = document.querySelectorAll('input')
  Array.from(choices).forEach(choice => {
    choice.addEventListener('click', (e) => {
      answers[number] = e.target.value
      Selected(choice)
    })
  })

  document.getElementById('previous').addEventListener('click', (e) => {
    number--
    Reset()
    getQuestion()
  })

  document.getElementById('next').addEventListener('click', (e) => {
    if(number < (questionaire.length-1) && answers[number]!=undefined){
      number++
      Reset()
      getQuestion()
    } else {
      showMessage()
    }
  })

  document.getElementById('submit').addEventListener('click', (e) => {
    if(answers[number]!=undefined){
      Swal.fire({
        icon: 'info',
        title: 'Submit answers?',
        html: 'Are you sure you want to submit your answers?',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-check-lg"></i> Confirm',
        cancelButtonText: '<i class="bi bi-x-lg"></i> Cancel',
        buttonsStyling: false,
        customClass: {
          confirmButton: 'btn btn-lg btn-success bg-gradient me-2',
          cancelButton: 'btn btn-lg btn-danger bg-gradient',
        },
        width: 400
      }).then((result) => {
        if(result.isConfirmed){
          Process()
          window.setTimeout((e) => {
            window.location.href = '?answers='+answers.toString()
          }, 2000)
        }
      })
    } else {
      showMessage()
    }
  })

  function Reset(){
    document.getElementById('a').checked = false
    document.getElementById('b').checked = false
    document.getElementById('c').checked = false
    document.getElementById('d').checked = false
    //reset
    document.getElementById('a').parentElement.classList.remove('active')
    document.getElementById('b').parentElement.classList.remove('active')
    document.getElementById('c').parentElement.classList.remove('active')
    document.getElementById('d').parentElement.classList.remove('active')
  }

  function Selected(option){
    //reset
    document.getElementById('a').parentElement.classList.remove('active')
    document.getElementById('b').parentElement.classList.remove('active')
    document.getElementById('c').parentElement.classList.remove('active')
    document.getElementById('d').parentElement.classList.remove('active')
    option.parentElement.classList.add('active')
  }

  function showMessage(){
    Swal.fire({
      icon: 'warning',
      title: 'Choose',
      text: 'Please select one of the provided options.',
      showConfirmButton: false,
      width: 350,
      timer: 1000
    })
  }

</script>
<?php endif; ?>

<script type="text/javascript" src="script/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>

<?php

if(isset($_SESSION['message'])):
  if($_SESSION['message']['page']!=basename($_SERVER['REQUEST_URI'])):
    unset($_SESSION['message']);
  endif;
endif;

?>