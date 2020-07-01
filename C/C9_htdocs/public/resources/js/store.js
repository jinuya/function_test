class Store{
    constructor(){
        this.list = [];
        this.maplist = {};
        this.basketList = [];
        this.basket_list = document.querySelector("#basket_list");
        this.drop_area = document.querySelector("#drop_area");
        this.basket_price = document.querySelector("#basket_price");
        this.store_list = document.querySelector("#store_list");
        this.search_form = document.querySelector("#search_form");
        this.cho = ["ㄱ","ㄲ",'ㄴ',"ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ",'ㅈ',"ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ"];

        this.drop_area.addEventListener("drop",this.drop);
        this.drop_area.addEventListener("dragover",this.dragover);
        this.search_form.addEventListener("keyup",this.search);
        document.querySelector("#basket_sell").addEventListener("click",this.recepit);
        document.querySelector("#basket_price_btn").addEventListener("click",this.basket_form_reset);

        fetch("resources/json/store.json")
        .then(res=>res.json())
        .then(data=>this.setting(data))
    }

    basket_form_reset(){
        const form = document.basket_form;
        form.name.value = "";
        form.port.value = "";
    }

    getCho(word){
        let result = "";
        for(let i = 0; i<word.length;i++){
            let idx = Math.floor((word[i].charCodeAt() - 44032)/588);
            result += (this.cho[idx] || word[i]);
        }
        return result;
    }

    match(keyword,item){
        let cho = this.getCho(item),result = null;
        let flag = false;
        for(let i =0; i<keyword.length;i++) this.cho.find(x=>{if(x == keyword[i]) flag = true});
        if(flag) result = cho.indexOf(keyword);
        else result = item.indexOf(keyword);
        return result;
    }
    
    search=e=>{
        this.store_list.innerHTML = "";
        let keyword = e.target.value,list = [];
        if(keyword.length == 0) this.list.forEach(x=>{this.StoreItemMake(x)});
        else{
            this.list.forEach(x=>{
                let {id,photo,brand,product_name,price,price_num,num} = x;
                let p_idx = this.match(keyword,product_name);
                if(p_idx !== -1) product_name = product_name.substr(0,p_idx)+"<mark>"+product_name.substr(p_idx,keyword.length)+"</mark>"+product_name.substr(keyword.length+p_idx,product_name.length);
                let b_idx = this.match(keyword,brand);
                if(b_idx !== -1) brand = brand.substr(0,b_idx) +"<mark>"+brand.substr(b_idx,keyword.length) +"</mark>"+brand.substr(keyword.length+b_idx,brand.length);
                if(p_idx !== -1 || b_idx !== -1) list.push({id,photo,brand,product_name,price,price_num,num});
            });
            if(list.length == 0) this.store_list.innerHTML = `<p id="not_search">일치하는 상품이 없습니다.</p>`;
            else list.forEach(x=>{this.StoreItemMake(x)});
        }
    }

    setting(data){
        this.store_list.innerHTML = "";
        data.forEach(x=>{
            x.price_num = parseInt(x.price.replace(/,/g,""));
            x.num = 1;
            this.StoreItemMake(x);
        });
        this.list = data;
        this.maplist = this.list.reduce((r,s)=>({...r,[s.id]:s}),{});
    }

    StoreItemMake({id,price,product_name,brand,photo}){
        let dom = document.createElement("div");
        dom.innerHTML = `<div class="card store_card">
                            <img src="resources/image/${photo}" alt="store_img" title="store_img" class="card-img" draggable="true" data-id="${id}">
                            <div class="card-body">
                                <h5 class="card-title">${product_name}</h5>
                                <p class="card-subtitle text-muted">${brand}</p>
                                <p class="card-text text-right">${price}원</p>
                            </div>
                        </div>`;
        dom.firstChild.addEventListener("dragstart",this.drag);
        this.store_list.appendChild(dom.firstChild);
    }

    drag = e=>{
        let id = e.target.getAttribute("data-id");
        e.dataTransfer.setData("id",id);
    }

    drop=e=>{
        let id = e.dataTransfer.getData("id");
        let flag = false;
        this.basketList.forEach(x=>{if(x == id) flag = true;});
        if(flag) return alert("이미 장바구니에 담긴 상품입니다.");
        this.basketList.push(id);
        this.MakeBasketItem();
    }

    dragover=e=>{e.preventDefault();}

    MakeBasketItem(){
        this.basket_list.innerHTML="";
        this.basketList.forEach((x,idx)=>{
            let item = this.maplist[x];
            let dom = document.createElement("tr");
            dom.innerHTML = `<td>${idx+1}</td>
                            <td><img src="resources/image/${item.photo}" alt="basket_img" title="basket_img" class="basket_img" draggable="false"></td>
                            <td>${item.product_name}</td>
                            <td>${item.brand}</td>
                            <td>${item.price}원</td>
                            <td><input type="number" class="form-control w-50 input_number" value="${item.num}" data-id="${x}"></td>
                            <td>${(item.price_num * item.num).toLocaleString()}원</td>
                            <td><button class="float-right basket_del text-white" data-id="${idx}">&times;</button></td>`;
            dom.querySelector(".input_number").addEventListener("change",this.changeNum);
            dom.querySelector(".basket_del").addEventListener("click",this.basket_del);
            this.basket_list.appendChild(dom);
        });
        this.BasketPrice();
    }

    basket_del=e=>{
        let target = e.target , id = target.getAttribute("data-id");
        this.basketList.splice(id,1);
        fetch("resources/json/store.json")
        .then(res=>res.json())
        .then(data=>this.setting(data))
        this.MakeBasketItem();
    }

    BasketPrice=e=>{
        let sum = 0;
        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            sum+=(item.num * item.price_num);
        });
        this.basket_price.innerHTML = sum.toLocaleString();
    }

    changeNum=e=>{
        let target = e.target,val = target.value,idx = target.getAttribute("data-id");
        val = parseInt(val);
        if(val < 1 || isNaN(val)) val = 1;
        target.value = val;
        this.maplist[idx].num = val;
        this.MakeBasketItem();
    }

    recepit=e=>{
        const form = document.basket_form;
        if(form.name.value == "" || form.port.value == "") return alert("내용을 입력해주세요.");
        $("#basket_close").trigger("click");
        
        const canvas = document.querySelector("#recepit");
        const ctx = canvas.getContext("2d");

        let fontSize = 15,offset = 10,base = 100,maxproduct = "",maxprice = "",maxnum = "",maxsum = "",list = [],sum = 0;

        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            item.sum = item.price_num * item.num;
            sum += item.sum;
            if(item.product_name.length > maxproduct.length) maxproduct = item.product_name;
            if(item.price.length > maxprice.length) maxprice = item.price;
            if((item.num+"").length > maxnum.length) maxnum = item.num+"";
            if((item.sum+"").length > maxsum.length) maxsum = item.sum+"";
            list.push(item);
        });

        let maxproductwidth = (maxproduct.length * fontSize),maxpricewidth = (maxprice.length * fontSize),maxnumwidth = (maxnum.length * fontSize),maxsumwidth = ( maxsum.length * fontSize),addbase = 0;
        if(maxproductwidth + base + maxpricewidth + maxnumwidth +maxsumwidth + (fontSize * 5) + (offset * 4) < 400) addbase = 400 - (maxproductwidth + base + maxpricewidth + maxnumwidth +maxsumwidth + (fontSize * 5) + (offset * 4))
        canvas.width = maxproductwidth + base + maxpricewidth + maxnumwidth +maxsumwidth + (fontSize * 5) + (offset * 4) + addbase;
        canvas.height = (list.length * (fontSize + offset)) + (fontSize * 8);
        ctx.font = fontSize+"px Arial";

        // 캔버스 ON!
        let top = fontSize,left = offset;
        
        ctx.fillText("상품명",left,top);
        left += maxproductwidth + fontSize + base;
        ctx.fillText('가격',left,top);
        left += maxpricewidth + fontSize + fontSize + fontSize + fontSize + offset;
        ctx.fillText("수량",left,top);
        left += maxnumwidth + fontSize + offset;
        ctx.fillText("합계",left,top);

        top += fontSize;

        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width - offset,top);
        ctx.stroke();

        list.forEach(x=>{
            top += offset + fontSize;
            left = offset;

            ctx.fillText(x.product_name,left,top);
            left += maxproductwidth + fontSize + base;
            ctx.fillText(x.price+'원',left,top);
            left += maxpricewidth + fontSize + fontSize + fontSize + fontSize + offset;
            ctx.fillText(x.num+"개",left,top);
            left += maxnumwidth + fontSize + offset;
            ctx.fillText(x.sum.toLocaleString()+"원",left,top);
        });

        top += fontSize;

        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width - offset,top);
        ctx.stroke();

        top += fontSize + offset;

        let now = new Date();
        ctx.fillText(`총합계 : ${sum.toLocaleString()}원`,offset,top);

        top+=offset+fontSize;

        let info = `구매일시 : ${now.getFullYear()}-${now.getMonth()+1}-${now.getDate()} ${(now+"").match(/[0-9]{2}:[0-9]{2}:[0-9]{2}/g)[0]}`;
        ctx.fillText(info,offset,top);

        $("#recepit_open").trigger("click");

        this.basketList = [];
        this.basket_list.innerHTML = "";
        this.basket_price.innerHTML = '0';

        fetch("resources/json/store.json")
        .then(res=>res.json())
        .then(data=>this.setting(data))
    }

}

window.onload=()=>{
    let store = new Store();
}