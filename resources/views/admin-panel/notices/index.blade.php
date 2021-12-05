@extends('admin-panel.base.main')
@section('css')
<!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        #form-container {
        width: 500px;
        }

        .row {
        margin-top: 15px;
        }
        .row.form-group {
        padding-left: 15px;
        padding-right: 15px;
        }
        .btn {
        margin-left: 15px;
        }

        .change-link {
        background-color: #000;
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
        bottom: 0;
        color: #fff;
        opacity: 0.8;
        padding: 4px;
        position: absolute;
        text-align: center;
        width: 150px;
        }
        .change-link:hover {
        color: #fff;
        text-decoration: none;
        }

        img {
        width: 150px;
        }

        #editor-container {
        height: 130px;
        }
    </style>
@endsection

@section('content')
    
<div id="form-container" class="container">
    <form id="tinymce_form">
      <div class="row">
        <div class="col-xs-8">
          <div class="form-group">
            <label for="display_name">Display name</label>
            <input class="form-control" name="display_name" type="text" value="Wall-E">
          </div>
          <div class="form-group">
            <label for="location">Location</label>
            <input class="form-control"  name="location" type="text" value="Earth">
          </div>
        </div>
        <div class="row form-group">
          <label for="about">About me</label>
          <input name="about" type="hidden">
          <div id="editor-container">
            <p>A robot who has developed sentience, and is the only robot of his kind shown to be still functioning on Earth.</p>
          </div>
        </div>
    </div>
      <div class="row">
        <button class="btn btn-primary" type="submit">Save Profile</button>
      </div>
    </form>
  </div>
  
@endsection

<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Initialize Quill editor -->
<script>

    setTimeout( () =>
    {
        var quill = new Quill('#editor-container', {
        modules: {
            toolbar: [
            ['bold', 'italic'],
            ['link', 'blockquote', 'code-block', 'image'],
            [{ list: 'ordered' }, { list: 'bullet' }]
            ]
        },
        placeholder: 'Compose an epic...',
        theme: 'snow'
        }); 
      var form = document.querySelector('#tinymce_form');
      form.onsubmit = function() {
      // Populate hidden form on submit
      var about = document.querySelector('input[name=about]');
      about.value = JSON.stringify(quill.getContents());
      
      console.log("Submitted", $(form).serialize(), $(form).serializeArray());
      
      // No back end to actually submit to!
      alert('Open the console to see the submit data!')
      return false;
      };
    }, 1000 );  

</script>

