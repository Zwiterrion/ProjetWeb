
function onCartButton(cb, id)
{
    var i = document.createElement("img");
    if(cb.checked)
        i.src = "panier.php?id=" + id;
    else
        i.src = "panier.php?delete&id=" + id;
}
