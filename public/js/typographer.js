function typographer(input) {
    let value = input.value;
    if (value.match("o'") || value.match("o`") || value.match("O'") || value.match("O`")) {
        value = value.replace("'", "\u2018");
        value = value.replace("`", "\u2018");
    }

    if (value.match("g'") || value.match("g`") || value.match("G'") || value.match("G`")) {
        value = value.replace("'", "\u2018");
        value = value.replace("`", "\u2018");
    }

    if (value.search("'") || value.search("`")) {
        value = value.replace("'", "\u2019");
        value = value.replace("`", "\u2019");
    }

    input.value = value;
}
