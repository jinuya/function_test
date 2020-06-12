class script{
    constructor(){
        window.addEventListener("click",this.click);
        this.captcha_word = null;
        this.housing_score = null;
        this.review_post = null;
        this.building_request_num = null;
        this.building_watch_num = null;
    }

    click = e =>{
        let target = e.target,id = e.target.id;
        if(target.classList.contains("building_watch_btn")) this.building_watch(target.getAttribute("data-id"));
        if(target.classList.contains("building_request_btn")) this.building_request_num = target.getAttribute("data-id");
        if(target.classList.contains("building_update_btn")) this.building_update(target.getAttribute("data-id"),target.getAttribute("data-request"));
        if(id == "building_request_btn") this.building_request();
        if(id == "building_post_btn") this.building_post();
        if(target.classList.contains("review_add_btn")) this.review_post = target.getAttribute("data-id");
        if(target.classList.contains("join")) this.captcha();
        if(id == "join_btn") this.join();
        if(id == "login_btn") this.login();
        if(id == "housing_write_btn") this.housing_write();
        if(target.classList.contains("addhousingScore")) this.housing_score = target.getAttribute("data-id");
        if(target.classList.contains("housing_score_send")) this.housing_score_send(target.getAttribute("data-value"));
        if(id == "writeSpecialist_btn") this.writeSpecialist();
    }

    building_update(post_id,request_id){
        if(post_id !== "" && request_id !== ""){
            $.ajax({
                url:"/buildingAccept",
                method:"post",
                data:{post_id:post_id,request_id:request_id},
                success(data){
                    alert("정상적으로 견적이 선택되었습니다.");
                    location.href = "/building";
                }
            });
        }
    }

    building_request(){
        const building_request_form = document.building_request_form;
        if(building_request_form.price.vlaue == "") return alert("내용을 입력해 주세요.");
        building_request_form.post_id.value = this.building_request_num;
        $("#building_request_send").trigger("click");
    }

    building_watch(id){
        $.ajax({
            url:"/buildingWatch",
            method:"post",
            data:{post_id:id},
            success(data){
                let result = JSON.parse(data);
                if(result !== false){
                    document.querySelector("#building_request_watch_list").innerHTML = "";
                    if(result.length == 0) document.querySelector("#building_request_watch_list").innerHTML = `<div class="card"><div class="card-body"><h5 class="card-title text-center">받은 견적이 없습니다.</h5></div></div>`;
                    else{
                        result.forEach(item =>{
                            let card = document.createElement("div");
                            card.classList.add("card");
                            card.classList.add("m-2");
                            let html = `
                            <div class="card-body">
                                <h4 class="card-title">${item.user_name}(${item.user_id})</h4>
                                <hr>
                                <p class="card-text">가격 : ${item.price}원</p>`;
                            if(item.status == "requesting") html+=`<button class="btn btn-primary float-right building_update_btn" data-id="${item.post_id}" data-request="${item.id}">선택</button>`;
                            html+=`</div>`;
                            card.innerHTML = html;
                            document.querySelector("#building_request_watch_list").appendChild(card);
                        });
                    }
                    console.log(result);
                }
            }
        })
    }

    building_request(){
        const building_request_form = document.building_request_form;
        if(building_request_form.price.value == "") return alert('내용을 입력해주세요.');
        building_request_form.post_id.value = this.building_request_num;
        $("#building_request_send").trigger("click");
    }

    building_post(){
        const building_post_form = document.building_post_form;
        if(building_post_form.day.value == "" || building_post_form.content.value == "") return alert("내용을 입력해주세요.");
        $("#building_post_send").trigger("click");
    }

    writeSpecialist(){
        const review_form = document.review_form;
        if(review_form.price.value == "" || review_form.content.value == "" || review_form.val.value == "") return alert("내용을 입력해주세요.");
        review_form.specialist_id.value = this.review_post;
        $("#writeSpecialist_send").trigger("click");
    }

    housing_score_send(val){
        if(this.housing_score == null) return;
        $.ajax({
            url:"/housingscoreadd",
            method:"post",
            data:{
                post_id:this.housing_score,
                value:val
            },
            success(data){
                alert("평점등록이 완료되었습니다.");
                location.href="/housing";
            }
        });
    }

    housing_write(){
        const housing_write_form = document.housing_write_form;
        if(housing_write_form.before_img.value == "" || housing_write_form.after_img.value == "" || housing_write_form.content.value == "") return alert("내용을 입력해주세요.");
        $("#housing_write_send").trigger("click");
    }

    login(){
        const login_form = document.login_form;
        if(login_form.user_id.value == "" || login_form.password.value == "") return alert("내용을 입력해 주세요.");
        $.ajax({
            url:"/logincheck",
            method:"post",
            data:{
                user_id:login_form.user_id.value,
                password:login_form.password.value
            },
            success(data){
                if(JSON.parse(data) == false) return alert("아이디 또는 비밀번호가 일치하지 않습니다.");
                else $("#login_send").trigger("click");
            }
        })
    }

    join(){
        const join_form = document.join_form;
        if(join_form.user_id.value == "" || join_form.user_name.value == "" || join_form.password.value == "" || join_form.img.value == "" || join_form.captcha_word.value == "") return alert("내용을 입력해 주세요.");
        if(join_form.captcha_word.value !== this.captcha_word) return alert("자동입력방지 문자를 잘못 입력하였습니다.");
        $.ajax({
            url:"/joincheck",
            method:"post",
            data:{user_id:join_form.user_id.value},
            success(data){
                if(JSON.parse(data) == false) return alert("중복되는 아이디입니다. 다른 아이디를 사용해주세요.");
                else $("#join_send").trigger("click");
            }
        });
    }

    captcha(){
        const canvas = document.querySelector("#captcha");
        const ctx = canvas.getContext("2d");
        this.captcha_word = Math.random().toString(26).substr(2,5);
        canvas.width = 468;
        canvas.height = 100;
        ctx.font = "80px arial";
        let width = ctx.measureText(this.captcha_word).width;
        ctx.fillText(this.captcha_word,((canvas.width - width) / 2),75);
    }
}

window.onload = () =>{
    let scr = new script();
}