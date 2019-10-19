<?php 
	require_once('functions.php');

$file = $_GET["file"];

if (!checkFile($file))
{
	header("Location: index.php"); 
}
$data = getFileInfo($file);
$numCols = $data['num_columns'];
$sampleData = $data['samples'];

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Code Generator - Processing File: <?php echo $file; ?></title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="node_modules/bulma-extensions/dist/css/bulma-extensions.min.css">
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
          <?php if ($numCols == 0) { ?>
            <div class="column">
              <center><strong>The file looks empty... we looked on the first row, and couldn't detect any columns</strong></center>
            </div>
          <?php } else { ?>
          <div class="column">
            <div class="card">
              <div class="card-content">
                <p class="title">
                  Detected <?php echo $numCols; ?> Columns
                </p>

                <table class="table is-bordered is-fullwidth has-text-centered">
                <thead>
                  <tr>
                  <?php for ($i = 1; $i<= $numCols; $i++) { ?> 
                    <th class="has-text-centered">col<?php echo $i; ?></th>
                  <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($sampleData as $row) { ?>
                    <tr>
                    <?php foreach($row as $col) { ?>
                      <td class="has-text-centered"><?php echo $col; ?></td>
                    <?php } ?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          <div class="column">
            <div class="card">
              <div class="card-content">
                <p class="title">
                  Now what?
                </p>
                <p>Use the token <code>^1^</code> to indicate where the column number should go (columns start at 1, not 0)</p><br />
                <p>Say we're writing a database seed file, and you want to deposit all of this into the database via insert statements.  This is how you'd mark the following query</p>
                <strong>format string</strong><br />
                <code> insert into (id, description) VALUES (^1^, ^2^);</code><br />
                <strong>would produce</strong><br />
                <code><?php
                  foreach($sampleData as $row) { 
                    echo 'insert into (id, description) VALUES (';
                    echo $row['col1'] . ', ' . $row['col2'] . '); <br />';
                  }
                ?></code>
                
              </div>
            </div>
          </div>

          <div class="column">
            <div class="card">
              <div class="card-content">                
                <p class="title">
                  Create Format
                </p>
                <textarea class="textarea" id="format_string">insert into (id, description) VALUES (^1^, ^2^);</textarea>
              </div>
              <footer class="card-footer">
                <a href="#" class="card-footer-item" onclick="javascript:code_format('<?php echo $file; ?>');">Format</a>
              </footer>
            </div>
          </div>


        <?php } ?>
        </div>
      </div>
    </section>
    <section class="section">
      <div class="columns">
        <div class="column" id="results_set">

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
    
    <script type="text/javascript" src="node_modules/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="node_modules/handlebars/dist/handlebars.min.js"></script>
    <script type="text/javascript" src="node_modules/bulma-extensions/dist/js/bulma-extensions.min.js"></script>
    <script type="text/javascript" src="node_modules/clipboard/dist/clipboard.min.js"></script>
    <script type="text/javascript" src="lib/main.js"></script>

    <script id="new-template" type="text/x-handlebars-template"><div class="card">
  <header class="card-header">
      <p class="card-header-title">
      {{runTime}} <button class="button is-text" data-clipboard-target="#response">COPY TEXT</button>
    </p>
  </header>
  <div class="card-content">
    <div class="content">
      <div class="columns">
        <div class="column">
          <strong>Regular Format</strong>
          <textarea id="response" rows="30" class="textarea">{{body}}</textarea>
        </div>
      </div>
    </div>
  </div>
</div></script>

  </body>
</html>