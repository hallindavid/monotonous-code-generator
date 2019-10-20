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
      <div class="column">
        <div id="file_selection"></div>
        <div id="log_output"></div>
      </div>
      
      <div class="column" onload="makeDropzone()">
        <strong>Upload your files</strong>
        <div class="dropzone" id="file_uploader"></div>
        <div id="error_container"></div>
      </div>
    </div>
  </div>
</section>
