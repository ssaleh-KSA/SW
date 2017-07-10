$(document).ready(function () {

	$('.Art-Delete').click(function () {

		return confirm('هل أنت متأكد من حذف المقال, لن يستطيع الزوار مشاهدته بعد ذالك');

	});

	$('.Account-Delete').click(function () {

		return confirm('هل أنت متأكد من حذف حسابك, سيتم حذف جميع بياناتك ومقالاتك وتعليقاتك من الموقع');

	});
	$('.user-Delete').click(function () {

		return confirm('هل أنت متأكد من حذف حساب هذا المستخدم, سيتم حذف بياناته ومقالاته وتعليقاته كلها');

	});
	$('.Comment-Delete').click(function () {

		return confirm('هل أنت متأكد من حذف هذا التعليق');

	});
	$('.ConMessage-Delete').click(function () {

		return confirm('هل أنت متأكد من حذف هذه الرسالة');

	});

});

/* Aside Navbar Start*/
function openNav() {

	document.getElementById('mySidenav').style.width = "400px";
	// document.body.style.backgroundColor = "rgba(0,0,0,0.4)";

}

function closeNav() {

	document.getElementById('mySidenav').style.width = '0';
	document.body.style.backgroundColor = "white";

}
/* Aside Navbar End */