
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height:100vh">
    <div class="card" style="width:23rem">
    <form action="cetak.php" method="post">
        <div class="card-header"><h3>Cetak Hasil UTS</h3></div>
        <div class="card-body">
            <div class="form-group">
                <label for="">Paste Link Google Sheets</label>
                <input type="text" name="makul" class="form-control">
            </div>
            <div class="form-group mt-2">
                <label for="">Judul</label>
                <input type="text" name="judul" class="form-control">
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" name="pilih" value='Proses' class="btn btn-info w-100">
        </div>
    </form>
    </div>
    
    </div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
</body>
</html>