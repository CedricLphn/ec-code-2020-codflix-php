$.get(`/api/?action=watchlist&query=check&id=${media_id}`).done((data) => {
    if (data.present == true) {
        $("#favorite").addClass("fas");
    } else {
        $("#favorite").addClass("far");

    }

});

$("#favorite").click(() => {
    $.get(`/api/?action=watchlist&query=toggle&id=${media_id}`).done((data) => {
        let etat = data.etat
        if (etat == "add") {
            $("#favorite").removeClass("fas");
            $("#favorite").addClass("far");
        } else {
            $("#favorite").removeClass("far");
            $("#favorite").addClass("fas");
        }
    })
})

$.ajax({
        url: 'https://api.themoviedb.org/3/search/tv?api_key=' + api_key + '&language=fr&query=' + media_title,
        dataType: 'jsonp',
    })
    .then(function (response) {
        response = response.results[0];
        $("#info").append(`<span class="badge badge-primary">${response.vote_average}</span>`)
        $(".jumbotron").css("background-image", `url(http://image.tmdb.org/t/p/original/${response.backdrop_path})`)
        $(".jumbotron").css("background-size", `cover`)
        let id = response.id;
        $.ajax({
                url: 'https://api.themoviedb.org/3/movie/' + id + '/credits?api_key=' + api_key + '',
                dataType: 'jsonp',
            })
            .then(function (credit) {
                for (let i = 0; i < 5; i++) {
                    let poster = credit.cast[i].profile_path != null ? `http://image.tmdb.org/t/p/w154/${credit.cast[i].profile_path}` : 'public/img/default.jpg'
                    let html = `
<div class="col-lg-2 ">
    <div class="row">
        <img src="${poster}" />
    </div>
    <div class="row">
        ${credit.cast[i].name}
    </div>
</div>`;
                    $("#actor").append(html);
                }

            });
    });

function toggle(block_id) {
    $(`#s${block_id}`).slideToggle();
}