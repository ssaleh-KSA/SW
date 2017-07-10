$(document).ready(function () {

	$('.Art-Delete').click(function () {

		return confirm('هل أنت متأكد من حذف المقال, لن يستطيع الزوار مشاهدته بعد ذالك');

	});

	$('.Account-Delete').click(function () {

		return confirm('هل أنت متأكد من حذف حسابك, سيتم حذف جميع بياناتك ومقالاتك وتعليقاتك من الموقع');

	});


});