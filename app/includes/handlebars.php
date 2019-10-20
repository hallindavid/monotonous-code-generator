<?php echo '<script id="upload_error" type="text/x-handlebars-template">'; ?>
<br />
<div class="notification is-danger">
  {{message}}
</div>
<?php echo '</script>'; ?>

<?php echo '<script id="no_files_template" type="text/x-handlebars-template">'; ?>
<strong>Once there are imported files, you'll see them here</strong>
  <br />
  <div class="content">
    You can either
    <ol>
      <li>Use the file uploader to the right</li>
      <li> drag a file manually into the folder called "import_folder" in the web root</li>
    </ol>
</div>
<?php echo '</script>'; ?>
<?php echo '<script id="loading_files_template" type="text/x-handlebars-template">'; ?>
<br /><br /><br />
<center><strong><i class="fas fa-sync fa-4x fa-spin"></i></strong></center>
<?php echo '</script>'; ?>
<?php echo '<script id="file_selection_template" type="text/x-handlebars-template">'; ?>
<strong>Select a file to begin</strong>
  <table class="table is-bordered is-fullwidth">
    <thead>
      <tr>
        <th>File</th>
      </tr>
    </thead>
    <tbody>
      {{#each files}}
      <tr>
        <td>
          <a href="/process_file?file={{file_name}}">{{file_name}}</a>
        </td>
      </tr>
      {{/each}}
    </tbody>
  </table>
<?php echo '</script>'; ?>

<?php echo '<script id="log_template" type="text/x-handlebars-template">'; ?>
<br />
  {{#if log_output}}
  <strong>Log</strong>
  <textarea class="textarea" rows="{{log_count}}">{{ log_output }}</textarea>
  {{/if}}
<?php echo '</script>'; ?>
<?php echo '<script id="format_results_template" type="text/x-handlebars-template">'; ?>
  
  <h1 class="title">Output</h1>
  <div class="card">
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
</div>
<?php echo '</script>'; ?>