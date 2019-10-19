<?php 
	require_once('functions.php');

$file = $_GET["file"];

if (!checkFile($file))
{
	header("Location: index.php"); 
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Code Generator - Processing File: <?php echo $file; ?></title>
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <section class="hero is-medium is-primary">
      <div class="hero-body">
        <div class="container">
          <div class="columns">
            <div class="column is-8-desktop is-offset-2-desktop">
              <h1 class="title is-2 is-spaced">
                Process File: <?php echo $file; ?>
              </h1>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section">
      <div class="container">
        <div class="columns">
          <div class="column is-8-desktop is-offset-2-desktop">
            <strong>Number of Columns</strong>
            <input type="number" class="input" value="2">
          </div>
        </div>
      </div>
    </section>
    <footer class="footer has-text-centered">
      <div class="container">
         <div class="columns">
          <div class="column is-8-desktop is-offset-2-desktop">
            <p>
              <small>
                Source code licensed <a href="http://opensource.org/licenses/mit-license.php">MIT</a>
              </small>
            </p>
            <p style="margin-top: 1rem;">
              <a href="http://bulma.io">
                <img src="made-with-bulma.png" alt="Made with Bulma" width="128" height="24">
              </a>
            </p>
          </div>
        </div>
      </div>
    </footer>
    <script type="text/javascript" src="lib/main.js"></script>
  </body>
</html>
