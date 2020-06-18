class Store{
    constructor(){
        this.list = [];
        this.maplist = {};
        this.basketList = [];
        this.basket_list = document.querySelector("#basket_list");
        this.store_list = document.querySelector("#store_list");
        this.basket_price = document.querySelector("#basket_price");
        this.basket_sell_btn = document.querySelector("#basket_sell_btn");
        this.drop_area = document.querySelector("#drop_area");
        this.search_form = document.querySelector("#search_form");
        this.cho = ["ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ"];

        this.setting();
    }

    getCho(word){
        let result = "";
        for(let i =0; i<word.length;i++){
            let cho = Math.floor((word[i].charCodeAt() - 44032)/588);
            result+=(this.cho[cho] || word[i]);
        }
        return result;
    }

    match(name,search){
        let cho = this.getCho(name),flag = false,idx = null;
        for(let i =0; i<search.length;i++) this.cho.find((x)=>{if(x == search[i])flag = true});
        if(flag) idx = cho.indexOf(search);
        else idx = name.indexOf(search);
        return idx;
    }

    search=e=>{
        let list = [],keyword = e.target.value;
        if(keyword.length > 0){
            this.list.forEach(x=>{
                let {id,photo,brand,product_name,price,price_num,num} = x;
                let p_idx = this.match(product_name,keyword);
                if(p_idx !== -1) product_name = product_name.substring(0,p_idx)+"<mark>"+product_name.substring(p_idx,p_idx+keyword.length)+"</mark>"+product_name.substring(p_idx+keyword.length,product_name.length);
                let b_idx = this.match(brand,keyword);
                if(b_idx !== -1) brand = brand.substring(0,b_idx)+"<mark>"+brand.substring(b_idx,b_idx+keyword.length)+"</mark>"+brand.substring(b_idx+keyword.length,brand.length);
                if(p_idx !== -1 || b_idx !== -1) list.push({id,photo,brand,product_name,price,price_num,num});
            });
            this.MakeStoreItem(list);
        }else this.MakeStoreItem(this.list);
    }

    setting(){
        fetch("resources/json/store.json")
        .then(res => res.json())
        .then(data => this.setList(data));

        this.drop_area.addEventListener("dragover",this.drop);
        this.drop_area.addEventListener("drop",this.dropHandle);
        this.basket_sell_btn.addEventListener("click",this.recepit);
        this.search_form.addEventListener("keyup",this.search);
        this.basket_list.innerHTML = "";
        this.basket_price.innerHTML = "0";
    }

    setList(data){
        data.forEach(x=>{
            x.price_num = x.price.replace(/,/g,"");
            x.num = 1;
            this.list.push(x);
        });
        this.maplist = this.list.reduce((r,x)=>({...r,[x.id]:x}),{});
        this.MakeStoreItem(this.list);
    }

    MakeStoreItem(list){
        this.store_list.innerHTML = "";
        if(list.length > 0){
            list.forEach(item=>{
                let dom = document.createElement("div");
                dom.innerHTML = `<div class="card store_card">
                                    <img src="resources/images/${item.photo}" alt="store_item" title="store_item" draggable="true" class="card-img store_item_img" data-id="${item.id}">
                                    <div class="card-body">
                                        <h5 class="card-title">${item.product_name}</h5>
                                        <p class="card-subtitle text-muted pt-2">${item.brand}</p>
                                        <p class="card-text p-2 text-right">${item.price}원</p>
                                    </div>
                                </div>`;
                dom.querySelector(".store_item_img").addEventListener("dragstart",this.dragHandle);
                this.store_list.appendChild(dom.firstChild);
            });
        }else this.store_list.innerHTML = "<p id='nowsearch'>일치하는 상품이 없습니다.</p>";
    }

    MakeBasketItem(){
        this.basket_list.innerHTML="";
        this.basketList.forEach((item_idx,idx)=>{
            let dom = document.createElement("tr");
            let item = this.maplist[item_idx];
            dom.innerHTML = `<td>${idx+1}</td>
                             <td><img src="resources/images/${item.photo}" class="basket_item_img" title="basket_item_img" alt="basket_item_img"></td>
                             <td>${item.product_name}</td>
                             <td>${item.brand}</td>
                             <td>${item.price}원</td>
                             <td><input type="number" min="1" value="${item.num}" class="form-control w-25 basket_num_input" data-id="${item.id}"></td>
                             <td>${this.price_type((item.price_num * item.num))}원</td>
                             <td><button class="basket_del close" data-id="${idx}" data-value="${item.id}">&times;</button></td>`;
            dom.querySelector(".basket_del").addEventListener("click",this.basketDel);
            dom.querySelector(".basket_num_input").addEventListener("change",this.basketNumUpdate);
            this.basket_list.appendChild(dom);
        });
        this.basketPrice();
    }

    basketNumUpdate=e=>{
        let target = e.target;
        let value = target.value,id = target.getAttribute("data-id");
        if(value < 1) value = 1;
        this.maplist[id].num = value;
        this.MakeBasketItem();
    }

    basketPrice(){
        let sum = 0;
        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            sum += (item.price_num * item.num);
        });
        let result = this.price_type(sum);
        this.basket_price.innerHTML = result;
    }

    basketDel=e=>{
        let id = e.target.getAttribute("data-id"),val = e.target.getAttribute("data-value");
        this.maplist[val].num = 1;
        this.basketList.splice(id,1);
        this.MakeBasketItem();
    }

    basketAdd(id){
        let flag = false;
        this.basketList.find((x)=>{if(x == id) flag = true;});
        if(flag) return alert("이미 장바구니에 담긴 상품입니다.");
        this.basketList.push(id);
        this.MakeBasketItem();
    }

    drop = e=>{ e.preventDefault(); }
    dropHandle = e=>{
        let id = e.dataTransfer.getData("id");
        this.basketAdd(id);
    }
    dragHandle = e=>{
        let id = e.target.getAttribute("data-id");
        e.dataTransfer.setData("id",id);
    }

    price_type(num){
        let price = num+"",result="";
        while(1){
            if(price.length < 4) break;
            result = price.substr(price.length-3,3)+","+result;
            price = price.substr(0,price.length-3);
        }
        result = price+","+result;
        result = result.substring(0,result.length-1);
        return result;
    }

    recepit=e=>{
        let form = document.basket_form;
        if(form.name.value == "" || form.port.value == "") return alert("내용을 입력해주세요.");
        if(this.basketList.length == 0) return alert("장바구니에 구매할 물건이 없습니다.");
        $("#basket_close").trigger("click");

        const canvas = document.querySelector("#recepit");
        const ctx = canvas.getContext("2d");

        let fontSize = 20,offset = 10,base_space = 100,sum = 0,list = [];
        let maxWidth = "",maxprice = "",maxsum ="",maxnum ="";
        ctx.font = fontSize+"px Arial";

        this.basketList.forEach(x=>{
            let item = this.maplist[x];
            item.sum = (item.price_num) * (item.num);
            sum+=item.sum;
            list.push(item);
            if(item.product_name.length > maxWidth.length) maxWidth = item.product_name;
            if(item.price.length > maxprice.length) maxprice = item.price;
            if((item.sum+"").length > maxsum.length) maxsum = item.sum+"";
            if((item.num+"").length > maxnum.length) maxnum = item.num+"";
        });

        let maxwidth = ctx.measureText(maxWidth).width,maxpricewidth = ctx.measureText(maxprice).width,maxnumwidth = ctx.measureText(maxnum).width,maxsumwidth = ctx.measureText(maxsum).width;
        canvas.width = maxwidth + base_space + maxpricewidth + maxnumwidth + maxsumwidth + 100;
        canvas.height = (list.length * (fontSize + offset)) + offset*10;
        
        // 그리기 시작
        let top = offset,left = offset;
        ctx.fillText("상품명",left,top);
        left += base_space+maxwidth+offset;
        ctx.fillText("가격",left,top);
        left += offset+maxpricewidth;
        ctx.fillText("개수",left,top);
        left += offset+offset+maxsumwidth;
        ctx.fillText("합계",left,top);

        top+=offset;

        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width - offset,top);
        ctx.stroke();

        for(let i = 0; i<list.length; i++){
            let item = list[i];
            top += offset+fontSize;
            left = offset;

            ctx.fillText(item.product_name,left,top);
            left += base_space+maxwidth+offset;
            ctx.fillText(item.price+"원",left,top);
            left += offset+maxpricewidth;
            ctx.fillText(item.num+"개",left,top);
            left += offset+offset+maxsumwidth;
            ctx.fillText(this.price_type(item.sum)+"원",left,top);
        }

        top+=offset;

        ctx.beginPath();
        ctx.moveTo(offset,top);
        ctx.lineTo(canvas.width - offset,top);
        ctx.stroke();

        top+=offset+fontSize

        let now = new Date();
        ctx.fillText(`총 합계 : ${this.price_type(sum)}원`,offset,top);
        let info = `구매일시 : ${now.getFullYear()}-${now.getMonth()}-${now.getDay()} ${now.toLocaleTimeString(3)}`;
        ctx.fillText(info,canvas.width - offset - ctx.measureText(info),top);

        this.basket_list.innerHTML="";
        this.basketList = [];
        this.maplist = this.list.reduce((r,s)=>({...r,[s.id]:s}),{});
        this.basket_price.innerHTML = "0";

        $("#recepit_open").trigger("click");
    }
}

window.onload=()=>{
    let store = new Store();
}