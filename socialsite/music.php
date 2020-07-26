<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <?php include "includes/head_imports_main.php";?>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css">
  <link rel="stylesheet" href="css/audio-player.css">
 <link rel='stylesheet' href='addTabs.css' />
<script src='code.js'></script>
<script src='AddTabs.js'></script>
<script src='jquery.form.min.js'></script>
<script src='jquery.maxlength.js'></script>		
  <title>jQuery</title>
</head>
<body>
<div class="container">
 <section class="audio-player">
          <i id="play-button"class="material-icons play-pause text-primary mr-2" aria-hidden="true">play_circle_outline</i>
          <i id="pause-button"class="material-icons play-pause d-none text-primary mr-2" aria-hidden="true">pause_circle_outline</i>
        <div class="progress-bar progress col-12 float-left;" >
		</div>
  <audio id="audio-player" class="d-none" src="https://archive.org/download/TabbyCatPurr/Purring.ogg" type="audio/mp3" controls="controls"></audio>
</section>
</div>
<div class="write_post">
                <?php echo $err_success_Msg; ?>
                    <?php include("includes/w_post_form.php"); ?>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
<script src="js/audioPlayer.js" charset="utf-8"></script>
</body>
</html>
