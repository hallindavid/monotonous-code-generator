<?php 
require_once('functions.php');

$query = cleanDirectoryAndGetFiles();
$files = $query['files'];
$log  = $query['log'];

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Code Generator</title>
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <section class="hero is-medium is-primary">
      <div class="hero-body">
        <div class="container">
          <div class="columns">
            <div class="column is-8-desktop is-offset-2-desktop">
              <h1 class="title is-2 is-spaced">
                Welcome to the Code Generator
              </h1>
              <h2 class="subtitle is-4">
                  This will hopefully speed up your development process significantly
                  <br />
                  <br />
                  Basically it takes in a CSV of information, and allows you to output a big textarea with a specific format
              </h2>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section">
      <div class="container">
        <div class="columns">
          <div class="column is-8-desktop is-offset-2-desktop">
            <?php
            if ($files != false) { ?>
            <strong>Select a file to begin</strong>
            <table class="table is-bordered is-fullwidth">
              <thead>
                <tr>
                  <th>File</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($files as $file) { ?>
                 <tr>
                  <td>
                    <a href="process_file.php?file=<?php echo $file; ?>"><?php echo $file; ?></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } else { ?>
              <div class="content">
                There don't appear to be any files in the import folder.
                <br /><br />
                Drag one into the folder called "import_folder" in the web root
                </div>
            <?php } ?>

            <strong>Log Output</strong>
            <?php if (($GLOBALS['log_output'])  && (count($log) > 0) ) { ?>
              <textarea class="textarea" rows="<?php echo count($log); ?>"><?php echo implode("\n", $log); ?></textarea>
            <?php } ?>
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
