window.addEventListener('load', function () {
    var url= 'http://www.laravel-project.com';

    document.querySelectorAll('.interactive_action i').forEach(item => {

        item.addEventListener('click', e => {

            e.preventDefault();
            var btn_i = e.target;
            var image_id = btn_i.dataset.target;

            var span = btn_i.nextSibling;

            fetch(`${url}/like/${image_id}`).then(response => response.json()).then(function (response) {

                if (response.ok) {

                    if (!response.like) {
                        btn_i.classList.remove("fas");
                        btn_i.classList.add("far");
                    } else {
                        btn_i.classList.remove("far");
                        btn_i.classList.add("fas");
                    } 
                    span.innerText = ` ${response.count}`
                }

            }).catch(function (err) { // There was an error
                console.warn('Something went wrong.', err);
            });
        })
    })

    var search=document.getElementById('search-user');

    search.addEventListener('submit',function (e) {
        
    })

    $('#search-user').submit(function(e){   
        $(this).attr('action',url+'/usuarios/'+$('#search').val()); 
    })

})

