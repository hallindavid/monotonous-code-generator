<?php 
$fileName = $_GET["file"];
$file = new FileScanner($fileName);
if (!$file->info("readable"))
{
  header("Location: /"); 
}

require_once(APPPATH."includes/header.php");
?>
    <section class="hero is-medium is-primary">
      <div class="hero-body">
        <div class="container">
          <div class="columns">
            <div class="column is-8-desktop is-offset-2-desktop">
              <h1 class="title is-2 is-spaced">
                Process File: <?php echo $file->info("filename"); ?>
              </h1>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section">
      <div class="container">
        <div class="columns">
          <?php if ($file->info("cols") == 0) { ?>
            <div class="column">
              <center><strong>The file looks empty... we looked on the first row, and couldn't detect any columns</strong></center>
              <?php var_dump($file->info()); ?>
            </div>
          <?php } else if ($file->info("rows") == 0) { ?>
            <div class="column">
              <center><strong>The file looks empty... we started to comb through it but couldn't detect any rows</strong></center>
            </div>
          <?php } else { ?>
          <div class="column">
            <div class="card">
              <div class="card-content">
                <p class="title">
                  Detected <?php echo $file->info("cols"); ?> Columns
                </p>

                <table class="table is-bordered is-fullwidth has-text-centered">
                <thead>
                  <tr>
                  <?php for ($i = 1; $i<= $file->info("cols"); $i++) { ?> 
                    <th class="has-text-centered">col<?php echo $i; ?></th>
                  <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($file->info("sample") as $row) { ?>
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
                  foreach($file->info("sample") as $row) { 
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
                <a href="javascript:code_format()" class="card-footer-item">Format</a>
                <input type="hidden" id="filename" value="<?php echo $file->info("filename"); ?>"/>
              </footer>
            </div>
          </div>
        <?php } ?>
        </div>
      </div>
    </section>
     <section class="section">
      <div class="container">
        <h1 class="title">Output</h1>
        <div class="columns">
          <div class="column" id="results_set"></div>
        </div>
      </div>
    </section>
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
<?php require_once(APPPATH."includes/footer.php"); ?>