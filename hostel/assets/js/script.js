// ============================
// Minor Frontend Functions
// ============================

// Confirm delete action
function confirmDelete(){
    return confirm("Are you sure you want to delete this?");
}

// Simple alert helper
function showMessage(msg){
    alert(msg);
}

// Example: Animate scroll to top
function scrollToTop(){
    window.scrollTo({top:0, behavior:'smooth'});
}
