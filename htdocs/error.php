<?php 
    if(isset($_SESSION['error'])) :
?>
        <style>
            .alert-danger {color: #ff0017;}
        </style>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fa-solid fa-circle-info"></i> Thất bại :</strong> <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
<?php 
    unset($_SESSION['error']);
    endif;
?>