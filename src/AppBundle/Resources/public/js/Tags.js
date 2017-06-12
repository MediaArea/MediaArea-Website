function display(tableBody, tableHeader) {
    if (document.getElementById(tableBody).className === "open") {
        document.getElementById(tableHeader).className = "plus";
        document.getElementById(tableBody).className = "closed";
    } else {
        document.getElementById(tableHeader).className = "minus";
        document.getElementById(tableBody).className = "open";
    }
}

function Line_Show(tableBody) {
    document.getElementById(tableBody + "H").className = "hidden";
    document.getElementById(tableBody + "S").className = "showed";
    document.getElementById(tableBody).className = "showed";
}

function Line_Hide(tableBody) {
    document.getElementById(tableBody + "H").className = "showed";
    document.getElementById(tableBody + "S").className = "hidden";
    document.getElementById(tableBody).className = "hidden";
}

function Col_Show(elem) {
    document.getElementById(elem).className = "hidden";
    for (var i = 0; i <= 200; i++) {
        if (document.getElementById(elem + i)) {
            document.getElementById(elem + i).className = elem;
        }
    }
}

function Col_Hide(elem) {
    document.getElementById(elem).className = "showed";
    for (var i = 0; i <= 200; i++) {
        if (document.getElementById(elem + i)) {
            document.getElementById(elem + i).className = "hidden";
        }
    }
}

function Line_Show_All() {
    Line_Show("Title");
    Line_Show("Organization");
    Line_Show("People");
    Line_Show("Classification");
    Line_Show("Temporal");
    Line_Show("Spacial");
    Line_Show("Personal");
    Line_Show("Technical");
    Line_Show("External");
    Line_Show("Commercial");
    Line_Show("Other");
    Line_Show("Nested");
}

function Line_Hide_All() {
    Line_Hide("Title");
    Line_Hide("Organization");
    Line_Hide("People");
    Line_Hide("Classification");
    Line_Hide("Temporal");
    Line_Hide("Spacial");
    Line_Hide("Personal");
    Line_Hide("Technical");
    Line_Hide("External");
    Line_Hide("Commercial");
    Line_Hide("Other");
    Line_Hide("Nested");
}

function Col_Show_All() {
    Col_Show("mi");
    Col_Show("mk");
    Col_Show("id");
    Col_Show("vo");
    Col_Show("ap");
    Col_Show("wm");
    Col_Show("ri");
    Col_Show("dc");
    Col_Show("de");
}

function Col_Hide_All() {
    Col_Hide("mi");
    Col_Hide("mk");
    Col_Hide("id");
    Col_Hide("vo");
    Col_Hide("ap");
    Col_Hide("wm");
    Col_Hide("ri");
    Col_Hide("dc");
    Col_Hide("de");
}
