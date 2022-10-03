<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD App Using CI 4 and Ajax</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <style>
.form-control {
    width: 20%;
}
.title {
    color :#2d7574
}
</style>
</head>

<body>
  <!-- add new post modal start -->
<h1 class="title">  Gestion Agriculture</h1>
  <form>
      <!-- add new User-->
  <div>
        <div class="mb-3">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nom">
        
        <div class="mb-3">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="prenom">
        </div>
  </div>


  <button type="submit" class="btn btn-primary">Ajouter +</button>
  <div class="mb-3">
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="type non ici...">
        </div>
  </div>
  <table  class="table">
  <thead>
    <tr>
      <th scope="col">Cvl</th>
      <th scope="col">Nom</th>
      <th scope="col">Prenom</th>
      <th scope="col">Tranche d'age</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Cvl</td>
      <td>Nom</td>
      <td>Prenom</td>
       <th> <button> delete </button> </th>
      <th> <button> Edit </button> </th>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
      <th> <button> delete </button> </th>
      <th> <button> Edit </button> </th>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
      <th> <button> delete </button> </th>
      <th> <button> Edit </button> </th>
    </tr>
  </tbody>
</table>
</form>
  <!-- add new post modal end -->

  

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(function() {
      // add new post ajax request
      $("#add_post_form").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#add_post_btn").text("Adding...");
          $.ajax({
            url: '<?= base_url('post/add') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              if (response.error) {
                $("#image").addClass('is-invalid');
                $("#image").next().text(response.message.image);
              } else {
                $("#add_post_modal").modal('hide');
                $("#add_post_form")[0].reset();
                $("#image").removeClass('is-invalid');
                $("#image").next().text('');
                $("#add_post_form").removeClass('was-validated');
                Swal.fire(
                  'Added',
                  response.message,
                  'success'
                );
                fetchAllPosts();
              }
              $("#add_post_btn").text("Add Post");
            }
          });
        }
      });

      // edit post ajax request
      $(document).delegate('.post_edit_btn', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?= base_url('post/edit/') ?>/' + id,
          method: 'get',
          success: function(response) {
            $("#pid").val(response.message.id);
            $("#old_image").val(response.message.image);
            $("#title").val(response.message.title);
            $("#category").val(response.message.category);
            $("#body").val(response.message.body);
            $("#post_image").html('<img src="<?= base_url('uploads/avatar/') ?>/' + response.message.image + '" class="img-fluid mt-2 img-thumbnail" width="150">');
          }
        });
      });

      // update post ajax request
      $("#edit_post_form").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#edit_post_btn").text("Updating...");
          $.ajax({
            url: '<?= base_url('post/update') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              $("#edit_post_modal").modal('hide');
              Swal.fire(
                'Updated',
                response.message,
                'success'
              );
              fetchAllPosts();
              $("#edit_post_btn").text("Update Post");
            }
          });
        }
      });

      // delete post ajax request
      $(document).delegate('.post_delete_btn', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?= base_url('post/delete/') ?>/' + id,
              method: 'get',
              success: function(response) {
                Swal.fire(
                  'Deleted!',
                  response.message,
                  'success'
                )
                fetchAllPosts();
              }
            });
          }
        })
      });
      // post detail ajax request
      $(document).delegate('.post_detail_btn', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?= base_url('post/detail/') ?>/' + id,
          method: 'get',
          dataType: 'json',
          success: function(response) {
            $("#detail_post_image").attr('src', '<?= base_url('uploads/avatar/') ?>/' + response.message.image);
            $("#detail_post_title").text(response.message.non);
            $("#detail_post_category").text(response.message.prenom);
            $("#detail_post_age").text(response.message.age);
            $("#detail_post_body").text(response.message.body);
            $("#detail_post_created").text(response.message.created_at);
          }
        });
      });

      // fetch all posts ajax request
      fetchAllPosts();

      function fetchAllPosts() {
        $.ajax({
          url: '<?= base_url('post/fetch') ?>',
          method: 'get',
          success: function(response) {
            $("#show_posts").html(response.message);
          }
        });
      }
    });
  </script>

</body>

</html>