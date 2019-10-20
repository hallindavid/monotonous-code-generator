<?php 
$dir = new DirectoryScanner();
$log = $dir->log();

?>
<section class="hero is-medium is-primary">
  <div class="hero-body">
    <div class="container">
      <div class="columns">
        <div class="column is-8-desktop is-offset-2-desktop">
          <h1 class="title is-2 is-spaced">
            Welcome to the Monotonous Code Generator
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
        if ($dir->files() != false) { ?>
        <strong>Select a file to begin</strong>
        <table class="table is-bordered is-fullwidth">
          <thead>
            <tr>
              <th>File</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($dir->files as $file) { ?>
             <tr>
              <td>
                <a href="/process_file?file=<?php echo $file; ?>"><?php echo $file; ?></a>
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
