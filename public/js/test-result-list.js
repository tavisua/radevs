function deleteTestResultItem(id){
    if(confirm('Delete this item?'))
    {
        location.href = '/delete-test-result/' + id;
    }
}
