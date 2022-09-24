<?php 
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="stylesheet" href="signup.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<div class="modal fade" id="signUpSuccessModal">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Sign Up</h5>
        </div>
        <div class="modal-body text-start">
            Akun berhasil dibuat!
        </div>
        <div class="modal-footer">
            <form action="" method="post">
                <button type="submit" class="btn btn-primary" name="signUpInfo">OK</button>
            </form>
        </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
      $("#signUpSuccessModal").modal("show");
  });
</script>
';
?>