class Script{
    constructor(){
        this.captcha = document.querySelector("#captchating");
        this.join_form = document.querySelector("#join_form");
        this.housing_number = null;
        this.review_number = null;
        this.building_post_number = null;
        this.captcha_text = "";
        this.event();
    }

    event(){
        window.addEventListener("click",e=>{
            let target = e.target;
            if(target.classList.contains("join_open_btn")){
                this.captcha_text = Math.random().toString(26).substr(2,5);
                let canvas = document.querySelector("#captcha");
                let ctx = canvas.getContext("2d");
                let fontSize = 60;
                canvas.width = 400;
                canvas.height = 100;
                ctx.font = fontSize+"px arial";
                ctx.fillText(this.captcha_text,fontSize+10,fontSize+10);
            }
            if(target.id=="join_btn") this.join();
            if(target.classList.contains("housing_addstar_btn")) this.housing_number = target.getAttribute("data-id");
            if(target.classList.contains("housing_score_btn")) this.housing_add_star(target);
            if(target.id == "housing_form_send_btn") this.housing_posting();
            if(target.classList.contains("specialist_review_add")) this.review_number = target.getAttribute("data-id");
            if(target.id == "review_send_btn") this.review_posting();
            if(target.id == "building_send_btn") this.buildingSend();
            if(target.classList.contains("building_btn")) this.building_post_number = target.getAttribute("data-id");
            if(target.id == "building_requesting_send_btn") this.buildingRequestSend();
            if(target.classList.contains("building_watching")) this.buildingRequestWatching(target.getAttribute("data-id"));
            if(target.classList.contains("buildingRequestChoose_btn")) this.buildingRequestChoose(target.getAttribute("data-postid"),target.getAttribute("data-id"));
        });
        window.addEventListener("change",e=>{
            let target = e.target;
            if(target.id=="review_score"){
                if(target.value < 1 ) target.value = 1;
                if(target.value > 5) target.value = 5;
            }
            if(target.id == "review_price"){
                if(target.value < 0) target.value = 0;
            }
        });
    }

    join(){
        const frm = document.joinfrm;
        if(frm.user_id.value == "" || frm.password.value == "" || frm.user_name.value == "" || frm.img.value == "" || frm.captcha.value == "") return alert("내용을 입력해 주세요.");
        if(this.captcha_text !== frm.captcha.value) return alert("자동입력방지 문자를 잘못 입력하였습니다.");
        $.ajax({
            url:"/JoinIdCheck",
            method:"post",
            data:{user_id:frm.user_id.value},
            success(data){
                if(JSON.parse(data).id) alert("중복되는 아이디입니다.다른 아이디를 사용해주세요.");
                else $("#join_submit").trigger("click");
            }
        })
    }

    housing_posting(){
        const housing = document.housing_form;
        if(housing.before_img.value == "" || housing.after_img.value == "" || housing.content.value == "") return alert("내용을 입력해주세요.");
        $("#housing_form_send").trigger("click");
    }

    housing_add_star(t){
        const housing_addStar = document.housing_add_star_form;
        let score = t.getAttribute("data-id");
        housing_addStar.post_id.value = this.housing_number;
        housing_addStar.val.value = score;
        $("#housing_score_add_btn").trigger("click");
    }

    review_posting(){
        const review_form = document.reivew_form;
        if(review_form.review_price.value == "" || review_form.review_content.value == "" || review_form.review_score.value == "") return alert("내용을 입력해주세요.");
        review_form.specialist_id.value = this.review_number;
        $("#review_send").trigger("click");
    }

    buildingSend(){
        const buildingSend = document.building_send_form;
        if(buildingSend.building_day.value == "" || buildingSend.building_content == "") return alert("내용을 입력해주세요.");
        $("#building_send").trigger("click");
    }

    buildingRequestSend(){
        const buildingRequest = document.building_requesting_form;
        if(buildingRequest.requesting_price.value == "") return alert("내용을 입력해주세요");
        buildingRequest.post_id.value = this.building_post_number;
        $("#building_requesting_send").trigger("click");
    }

    buildingRequestWatching(id){
        let list = document.querySelector("#building_list");
        $.ajax({
            url:"/BuildingRequestWatch",
            method:"post",
            data:{
                building_post:id
            },
            success(data){
                let post = JSON.parse(data);
                list.innerHTML = "";
                if(post.length == 0) list.innerHTML = `<p class="modal-title p-2 text-center">받은 견적이 없습니다</p>`;
                else{
                    post.forEach(x =>{
                        let card = document.createElement("div");
                        card.classList.add("card");
                        card.classList.add("m-2");
                        let text = `
                        <div class="card-body">
                            <h5 class="card-title">${x.user_name}(${x.user_id})</h5>
                            <p class="card-subtitle text-muted">비용 : ${x.price} 원</p>`;
                            if(x.status == "requesting") text += `<button class="btn btn-primary float-right buildingRequestChoose_btn" data-postid = "${x.post_id}" data-id="${x.id}">선택</button>`
                        text+=`</div>`;
                        card.innerHTML = text;
                        list.appendChild(card);
                    });
                }
            }
        });
    }

    buildingRequestChoose(pd,rd){
        $.ajax({
            url:"/BuildingChoose",
            method:"post",
            data:{
                post_id:pd,
                requesting_id:rd
            },
            success(data){
                if(JSON.parse(data)){
                    $("#buildingReauesting_watch_popup_close").trigger("click");
                    alert("견적이 정상적으로 선택되었습니다.");
                    location.href = "/building";
                }
            }
        });
    }
}

window.onload = ()=>{
    let start = new Script();
}