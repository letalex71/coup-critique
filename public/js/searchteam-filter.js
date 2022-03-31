$('.searchteam-filter').submit(function () {

    var pokemonField = $('#pokemon')

    let pokemons = $("#pokemon").next().children();

    for (pokemon of pokemons)
    {
        if(pokemon.label === pokemonField.val())
            pokemonField.val(pokemon.attributes['data-id'].nodeValue);
    }

});
