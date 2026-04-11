// Inventory
function inventoryUpdateStock(id, stock, status){
    $('#updateForm').attr('action', '/inventory-update/' + id);
    $('#stock').val(stock);
    $('#status').val(status);
}

function inventoryUpdateStock1(id, stock, status){
    window.alert(1);
}

function inventoryUpdateStatus(id, stock, status){
    $('#updateForm').attr('action', '/inventory-update/' + id);
    $('#stock').val(stock);
    $('#status').val(status);
    $('#updateForm').submit();
}

// Approvals
function showDetails(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/approvals-view/'+id);
}

function hideDetails(){
    $('.tbl').removeAttr('style');
    $('#view').html('');
}

function downloadFile(id){
    window.location.href = "/approvals-download/" + id;
}

function setApproveUser(userId) {
    document.getElementById('approve_user_id').value = userId;
}

function approve(id){
    
}

function reject(id){
    $('#rejectForm').attr('action', '/approvals-reject/'+id);
}

// Users
function userShow(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/users-view/'+id);
}

function userHide(){
    $('.tbl').removeAttr('style');
    $('#view').html('');
}

function userCreate(){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/users-create/');
}

function userUpdate(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/users-update/'+id);
}

function userDelete(id){
    $('#deleteForm').attr('action', '/users-destroy/'+id);
}

// Products
function productShow(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/products-view/'+id);
}

function productHide(){
    $('.tbl').removeAttr('style');
    $('#view').html('');
}

function productCreate(){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/products-create/');
}

function productUpdate(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/products-edit/'+id);
}

function productDelete(id){
    $('#deleteForm').attr('action', '/products-destroy/'+id);
}

function toggleProductCheckbox(imageId) {
    var checkbox = document.getElementById("img-checkbox-" + imageId);
    var image = document.getElementById("img-" + imageId);
    var checkmark = document.getElementById("checkmark-" + imageId);

    // Toggle checkbox state
    checkbox.checked = !checkbox.checked;

    // Adjust image opacity and checkmark visibility based on the checkbox state
    if (checkbox.checked) {
        image.classList.add("selected");
        checkmark.style.opacity = '1';  // Show checkmark
        image.style.opacity = '0.5';   // Make image semi-transparent
    } else {
        image.classList.remove("selected");
        checkmark.style.opacity = '0';  // Hide checkmark
        image.style.opacity = '1';     // Reset image opacity
    }
}


// Products Category
function productCategoryShow(id){
    // Clear old content while loading
    $('#subCategories').html('<p>Loading...</p>');

    // Load the sub-category table from backend
    $('#subCategories').load('/product-categories-view/' + id);
}

function productCategoryHide(){
    $('.tbl').removeAttr('style');
    $('#view').html('');
}

function productCategoryCreate(){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/product-categories-create/');
}

function productCategoryUpdate(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/product-categories-edit/'+id);
}

function productCategoryDelete(id){
    $('#deleteForm').attr('action', '/product-categories-destroy/'+id);
}

// Products Variants
function productVariantShow(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/product-variants-view/'+id);
}

function productVariantHide(){
    $('.tbl').removeAttr('style');
    $('#view').html('');
}

function productVariantCreate(){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/product-variants-create/');
}

function productVariantUpdate(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/product-variants-edit/'+id);
}

function productVariantDelete(id){
    $('#deleteForm').attr('action', '/product-variants-destroy/'+id);
}

// Catalogue
function catalogueShow(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/catalogue-view/'+id);
}

function catalogueHide(){
    $('.tbl').removeAttr('style');
    $('#view').html('');
}

function catalogueCreate(){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/catalogue-create/');
}

function catalogueUpdate(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/catalogue-edit/'+id);
}

function catalogueDelete(id){
    $('#deleteForm').attr('action', '/catalogue-destroy/'+id);
}

// Quotations
function quotationShow(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/quotations-view/'+id);
}

function quotationHide(){
    $('.tbl').removeAttr('style');
    $('#view').html('');
}

function quotationCreate(){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/quotations-create/');
}

function quotationUpdate(id){
    $('.tbl').attr('style', 'display: none;');
    $('#view').load('/quotations-edit/'+id);
}

function quotationDelete(id){
    $('#deleteForm').attr('action', '/quotations-destroy/'+id);
}

// Active Navbar UI
$(document).ready(function(){
    var pathname = window.location.pathname;
    pathname = pathname.substring(1, pathname.length);

    $("a[href='/"+ pathname +"']").parent().addClass(" menu-open");
    $("a[href='/"+ pathname +"']").addClass(" active");

    switch(pathname){
        case "dashboard":
        case "inventory":
        case "order":
        case "consumer":
        case "approvals":
        case "users":
        case "products":
        case "product-categories":
        case "catalogue":
        case "admin-control":
        case "audit-trail":
        $("a[href='/"+ pathname +"']").parent().parent().parent().addClass("menu-is-opening");
        $("a[href='/"+ pathname +"']").parent().parent().parent().addClass("menu-open");
        $("a[href='/"+ pathname +"']").attr("style", "width: 93%;")
        break;
    }
    $(".wrapper").removeAttr("style");

});
