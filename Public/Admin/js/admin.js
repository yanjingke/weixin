function checkall(){ //jquery获取复选框值
    var chk_value =[];
    $('input[name="ids[]"]:checked').each(function(){
        chk_value.push($(this).val());
    });
    if(chk_value.length==0){
        alert('你还没有选择任何内容！');
    }else{
        if(confirm('确定要删除吗?')){
            var url = "";
            $.post(url,{data:chk_value,act:'all'},function(data){
                if(data =='ok'){
                    alert('操作成功!')
                }else{
                    alert('操作失败!')
                }
                window.location.reload();
            },'text');
        }
    }
}

