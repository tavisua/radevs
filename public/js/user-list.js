function deleteUserItem(id){
    if(confirm('Delete this item?'))
    {
        location.href = '/delete-user/' + id;
    }
}
