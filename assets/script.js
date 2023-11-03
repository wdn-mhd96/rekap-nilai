$(document).ready(function(){
    $('#tabel-nilai').DataTable();
});
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
const menu = document.querySelectorAll('.menu-link');
    menu.forEach(function(e) {
        (e.href === window.location.href) ? e.classList.add('active') : "";
    });
    function showSuggestion(str) {
        if (str.length == 0) {
            document.getElementById("suggestion-box").innerHTML = "";
            return;
        } else {
            $.ajax({
                url: "dosen_sug.php",
                method: "POST",
                data: {
                    search: str
                },
                success: function (data) {
                    document.getElementById("suggestion-box").innerHTML = data;
                }
            });
        }
    }
    function showSuggestionMakul(str) {
        if (str.length == 0) {
            document.getElementById("suggestion-makul").innerHTML = "";
            return;
        } else {
            $.ajax({
                url: "dosen_sug.php",
                method: "POST",
                data: {
                    makul: str
                },
                success: function (data) {
                    document.getElementById("suggestion-makul").innerHTML = data;
                }
            });
        }
    }

    $('#cek').click((e)=> {
        e.preventDefault();
        $.ajax({
            url:"dosen_sug.php",
            method:"POST",
            data :{
                sheets : $('#sheets').val()
            },
            success :function(data) {
                $('#check-data').html(data);
            }
        })
    })

    document.getElementById('suggestion-box').addEventListener('click', (e) => {    
        if (e.target.classList.contains('sugdosen')) {
        document.getElementById('search').value = e.target.innerHTML;
        document.getElementById('kdDosen').value = e.target.getAttribute('data-kd');
        document.getElementById('suggestion-box').innerHTML = "";
    }
    });


    document.getElementById('suggestion-makul').addEventListener('click', (e) => {    
        if (e.target.classList.contains('sugmakul')) {
        document.getElementById('makul').value = e.target.innerHTML;
        document.getElementById('kdMakul').value = e.target.getAttribute('data-id');
        document.getElementById('suggestion-makul').innerHTML = "";
    }
    });
   