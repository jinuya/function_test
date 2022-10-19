class building{
    constructor(){
        this.request_post_id = null;
        this.request_choose_id = null;
        this.request_list = document.querySelector("#request_list_body");
        window.addEventListener("click",this.event);
        this.event();
    }

    event =e=>{
        if(e!==undefined){
            let target = e.target;
            if(target.id == "building_request_btn") this.request_post_id = target.getAttribute("data-id");
            if(target.classList.contains("request_send_close")) this.request_post_id = null;
            if(this.request_post_id !== null && target.id == "request_send_btn"){
                let price = document.querySelector("#request_send_price").value;
                $.ajax({
                    url:"/BuildingrequestSend",
                    method:"post",
                    data:{
                        request_price:price,
                        post_id:this.request_post_id
                    },
                    success(data){
                        console.log(JSON.parse(data));
                        if(JSON.parse(data)==true){
                            $("#building_request_see_btn").trigger("click");
                            this.request_post_id = null;
                            location.href = "/building";
                        }else alert(JSON.parse(data));
                    }
                });
            }
            if(target.id == "building_request_see_btn"){
                let id = target.getAttribute("data-id");
                $.ajax({
                    url:"/BuildingrequestLoad",
                    method:"post",
                    data:{
                        post_id:id
                    },
                    success(data){
                        let list = JSON.parse(data);
                        if(list!==false){
                            $("#request_see_open").trigger("click");
                            document.querySelector("#request_list_body").innerHTML = "";
                            list.forEach(item =>{
                                let card = document.createElement("div");
                                card.classList.add("card");
                                card.classList.add("m-2");
                                card.innerHTML = `<div class="card-body">
                                                        <h5 class="card-title">${item.user_name}(${item.user_id})</h5>
                                                        <p class="card-text">비용 : ${item.price}원</p>`;
                                if(item.status == "requesting") card.innerHTML += `<button class="btn btn-success float-right building_request_choose_btn" data-post="${id}" data-id="${item.id}">선택</button>`;
                                card.innerHTML+=`</div>`;
                                document.querySelector("#request_list_body").appendChild(card);
                            });
                        }
                    }
                });
            }

            if(target.classList.contains("building_request_choose_btn")){
                let id = target.getAttribute("data-post");
                let card_id = target.getAttribute("data-id");
                $.ajax({
                    url:"/BuildingrequestChoose",
                    method:"post",
                    data:{
                        post_id:id,
                        choose_id:card_id
                    },
                    success(data){
                        let result = JSON.parse(data);
                        if(result == true)location.href="/building";
                        else alert(result);
                    }
                });
            }

        }
    }
}

window.onload=()=>{
    let start = new building();
}