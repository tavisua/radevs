function deleteTestItem(id){
    if(confirm('Delete this item?'))
    {
        location.href = '/delete-test/' + id;
    }
}
