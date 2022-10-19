class Housing{
    constructor(){
        this.postNumber = null;
        this.reviewNumber = null;
        this.event();
    }
    event(){
        window.addEventListener("click",(e)=>{
            if(e.target.classList.contains("HousingaddScore")){
                this.postNumber = e.target.getAttribute("data-id");
                $("#open_housing_add_score_popup").trigger("click");
            }
            if(e.target.classList.contains("housing_score_add") && this.postNumber!==null){
                let score = e.target.getAttribute("data-id");
                $.ajax({
                    url:"/housingAddScore",
                    method:"post",
                    data:{
                        "score":score,
                        "housing_id":this.postNumber
                    },
                    success(result){
                        $("#close_housing_add_score_popup").trigger("click");
                        this.postNumber = null;
                        location.href = "/online";
                    }
                });
            }
            if(e.target.id == "close_housing_add_score_popup") this.postNumber = null;
            if(e.target.classList.contains("reviewadd_close")) this.reviewNumber = null;
            if(e.target.id == "review_write_btn"){this.reviewNumber = e.target.getAttribute("data-id");}
            if(e.target.id == "afterReview_btn" && this.reviewNumber !== null) {
                let score = document.querySelector("#review_score").value;
                let content = document.querySelector("#review_content").value;
                let price = document.querySelector("#review_price").value;
                console.log(score);
                if(content == "" || price == "") return alert("내용을 입력해주세요.");
                $.ajax({
                    url:"/ReviewAdd",
                    method:"post",
                    data:{
                        "specialist_id":this.reviewNumber,
                        "score":score,
                        "content":content,
                        "price":price
                    },
                    success:(data)=>{
                        $(".reviewadd_close").trigger("click");
                        location.href = "/specialist";
                    }
                })
            }
        });
    }
}

window.onload = () =>{
    let app = new Housing();
}