<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
#BEGIN: Defaults
$lang['title_defaults'] = 'ĐĂNG KÝ';
$lang['username_defaults'] = 'Tài khoản';
$lang['password_defaults'] = 'Mật khẩu';
$lang['repassword_defaults'] = 'Nhập lại mật khẩu';
$lang['email_defaults'] = 'Email';
$lang['reemail_defaults'] = 'Nhập lại Email';
$lang['fullname_defaults'] = 'Họ tên';
$lang['birthday_defaults'] = 'Ngày sinh';
$lang['sex_defaults'] = 'Giới tính';
$lang['address_defaults'] = 'Địa chỉ';
$lang['province_defaults'] = 'Tỉnh / Thành phố';
$lang['phone_defaults'] = 'Điện thoại';
$lang['yahoo_defaults'] = 'Nick Yahoo';
$lang['skype_defaults'] = 'Nick Skype';
$lang['regis_vip_defaults'] = 'Đăng ký thành viên VIP';
$lang['regis_shop_defaults'] = 'Đăng ký cửa hàng ảo';
$lang['button_register_defaults'] = 'Đăng ký';
$lang['button_reset_defaults'] = 'Làm lại';
$lang['male_defaults'] = 'Nam';
$lang['female_defaults'] = 'Nữ';
$lang['stop_regis_defaults'] = '<font color="#FF0000">Website tạm ngưng đăng ký thành viên</font>';
$lang['guide_regis_vip_defaults'] = 'Tài khoản <font color="#FF0000"><b>VIP</b></font> của bạn sau khi đăng ký <font color="#0099FF"><b><i>chưa được phép sử dụng</i></b></font>. Để kích hoạt tài khoản <font color="#FF0000"><b>VIP</b></font> bạn vui lòng <a class="menu_1" href="./contact" title="Liên hệ" target="_blank" style="font-weight:bold;">liên hệ</a> với chúng tôi để được hướng dẫn cụ thể.
									<p><b>Chi phí di trì tài khoản <font color="#FF0000"><b>VIP</b></font>:</b></p>
									<blockquote>
										<b>&bull;</b> 50.000 VNĐ/1 tháng.<br>
										<b>&bull;</b> 200.000 VNĐ/6 tháng.<br>
										<b>&bull;</b> 300.000 VNĐ/1 năm.
									</blockquote>
									<b>Mọi chi tiết bạn có thể <a class="menu_1" href="./contact" target="_blank" title="Liên hệ" style="font-weight:bold;">liên hệ</a> với chúng tôi theo:</b>
									<blockquote>
										<b>&bull; Điện thoại:</b> '.Setting::settingPhone.'<br>
										<b><i>&bull; Hotline:</i></b> '.Setting::settingMobile.'<br>
										<b>&bull; Email:</b> <a class="menu_1" href="mailto:'.Setting::settingEmail_1.'">'.Setting::settingEmail_1.'</a><br>
										<b>&bull; Nick Yahoo:</b> <a class="menu_1" href="ymsgr:SendIM?'.Setting::settingYahoo_1.'">'.Setting::settingYahoo_1.'</a>
									</blockquote>
									<i>(Hình thức thanh toán: thanh toán chuyển khoản qua ngân hàng)</i>';
$lang['guide_regis_shop_defaults'] = 'Tài khoản <font color="#FF0000"><b>Cửa hàng ảo</b></font> của bạn sau khi đăng ký <font color="#0099FF"><b><i>chưa được phép sử dụng</i></b></font>. Để kích hoạt tài khoản <font color="#FF0000"><b>Cửa hàng ảo</b></font> bạn vui lòng thực hiện 1 trong 2 cách sau:
									<p><b>&diams; Cách 1:</b></p>
									<blockquote>
										1. Cung cấp thông tin cửa hàng theo mẫu (<a class="menu_1" href="'.base_url().'templates/guide/data/maucungcapthongtin.doc" style="font-weight:bold;" target="_blank" title="Tải mẫu cung cấp thông tin">Tải tại đây</a>).<br>
										2. Gởi mẫu thông tin cửa hàng tới Email <a class="menu_1" href="mailto:chosoc@gmail.com" style="font-weight:bold;" title="chosoc@gmail.com">chosoc@gmail.com</a>.<br>
										3. Gởi kèm theo logo, banner (nếu có).
									</blockquote>
									<p><b>&diams; Cách 2:</b></p>
									<blockquote>
										Cung cấp thông tin cửa hàng qua Yahoo Chat <a class="menu_1" href="ymsgr:SendIM?'.Setting::settingYahoo_1.'" style="font-weight:bold;" title="'.Setting::settingYahoo_1.'">'.Setting::settingYahoo_1.'</a> với các thông tin sau: <b><i>tên tài khoản, tên cửa hàng, địa chỉ cửa hàng, điện thoại, danh mục cửa hàng</i></b>.
									</blockquote>
									<i>Chúng tôi sẽ setup <font color="#FF0000"><b>Cửa hàng ảo</b></font> trong vòng 24 giờ (trừ thứ bảy và chủ nhật) sau khi tiếp nhận đầy đủ thông tin cửa hàng theo yêu cầu. Bạn có thể chỉnh sửa thông tin <font color="#FF0000"><b>Cửa hàng ảo</b></font> qua chức năng quản lý của website.</i>';
$lang['title_role_normal_defaults'] = 'Quy định đối với thành viên';
$lang['title_role_vip_defaults'] = 'Quy định và quyền lợi của thành viên VIP';
$lang['title_role_saler_defaults'] = 'Quy định và quyền lợi khi đăng ký cửa hàng';
$lang['role_normal_defaults'] = '<b><i>Khi bạn trở thành thành viên của <a class="menu" href="./">mua3s.vn</a> bạn cần tuân theo những quy định sau:</i></b>
                                <p><b>A. Những quy định về việc đăng ký và quản lý tài  khoản:</b></p>
                                    <ol>
                                        <li>Tài  khoản đăng ký, thông tin cá nhân của bạn phải hợp lệ (không được dùng các từ ngữ  thô tục, kém văn hóa, gây ảnh hưởng xấu đến <a class="menu" href="./">mua3s.vn</a>, xúc phạm đến người  khác, vi phạm pháp luật…).</li>
                                        <li>Thành  viên sau khi đăng ký phải có trách nhiệm tự quản lý tài khoản và mật khẩu. Nếu  thành viên không quản lý tốt để người thứ ba lấy được tài khoản, chúng tôi sẽ không chịu trách nhiệm về bất cứ những tổn thất phát sinh  do việc để mất tài khoản  gây ra.Trong trường hợp mất  tài khoản, bạn phải báo với chúng tôi để được giải quyết kịp thời.</li>
                                        <li>Nếu  bạn quên mật khẩu bạn có thể <a class="menu" href="./contact">liên hệ</a> với bộ phận kỹ thuật để được giải quyết cấp  mới mật khẩu. Trong trường hợp bạn quên cả tên tài khoản lẫn mật khẩu, chúng  tôi sẽ căn cứ vào những thông tin mà bạn cung cấp có phù hợp với thông tin mà bạn  đã đăng ký trên <a class="menu" href="./">mua3s.vn</a> hay không.</li>
                                        <li>Nếu  tài khoản của bạn không hoạt động trong một khoản thời gian nhất định chúng tôi  sẽ xóa tài khoản của bạn mà không cần báo trước.</li>
                                        <li>Thông  tin các bạn đăng ký trên <a class="menu" href="./">mua3s.vn</a> thuộc quyền sở hữu của <a class="menu" href="./">mua3s.vn</a>.  Chúng tôi có quyền sử dụng những thông tin của bạn khi cần thiết.</li>
                                        <li>Trong  trường hợp bạn không muốn sử dụng tài khoản của mình nữa, bạn có thể <a class="menu" href="./contact">liên hệ</a> với  chúng tôi để chúng tôi hủy bỏ tài khoản của bạn.</li>
                                    </ol>
                                <p><b>B. Những quy định khi tham gia vào <a class="menu" href="./">CHOSOC</a>:</b></p>
                                    <ol>
                                        <li>Tài  khoản của bạn được phép đăng tin rao vặt, đăng tin tuyển dụng, đăng tin tìm việc  (không được phép đăng sản phẩm).</li>
                                        <li>Những  tin đăng không đúng sự thật, không đúng quy định (thông tin cung cấp quá ít, nội  dung không rõ ràng, sử dụng từ ngữ kém văn hóa, vi phạm pháp luật…) sẽ bị xóa  mà không cần báo trước.</li>
                                        <li>Tất  cả các thành viên của <a class="menu" href="./">mua3s.vn</a> đều được chúng tôi trợ giúp khi có yêu cầu.</li>
                                        <li>Các  thành viên không được phép sử dụng <a class="menu" href="./">mua3s.vn</a> sai mục đích, không được lợi  dụng vào <a class="menu" href="./">mua3s.vn</a> để lừa đảo, thực hiện những hành vi vi phạm pháp luật,  gây tổn hại đến cá nhân hoặc công ty khác.</li>
                                        <li>Các  thành viên không được gây tổn hại đến <a class="menu" href="./">mua3s.vn</a>, thực hiện những hành vi để  làm giảm uy tín của <a class="menu" href="./">mua3s.vn</a>.</li>
                                        <li>Trong  trường hợp có tranh chấp, khiếu nại các thành viên có thể <a class="menu" href="./contact">liên hệ</a> với chúng tôi  để được giải quyết thích đáng. Trong trường hợp chúng tôi không thể giải quyết  được thì chúng tôi sẽ đưa ra pháp luật để giải quyết.</li>
                                        <li>Chúng  tôi có toàn quyền quyết định để xử lý các thành viên nếu vi phạm những quy định  trên.</li>
                                    </ol>';
$lang['role_vip_defaults'] = '<b><i>Những quy định và quyền lợi của bạn khi bạn đăng ký thành viên VIP trên <a class="menu" href="./">mua3s.vn</a>:</i></b>
                              <p><b>A. Những quy định về việc đăng ký và quản lý  tài khoản:</b></p>
                                    <ol>
                                        <li>Tài  khoản của bạn sau khi đăng ký chưa sử dụng được, để sử dụng tài khoản này bạn  vui lòng <a class="menu" href="./contact">liên hệ</a> với chúng tôi để được hướng dẫn chi tiết.</li>
                                        <li>Nếu  quá thời hạn 7 ngày sau khi đăng ký mà bạn không <a class="menu" href="./contact">liên hệ</a> với chúng tôi thì  chúng tôi sẽ xóa tài khoản này.</li>
                                        <li>Tài  khoản đăng ký, thông tin cá nhân của bạn phải hợp lệ (không được dùng các từ ngữ  thô tục, kém văn hóa, gây ảnh hưởng xấu đến <a class="menu" href="./">mua3s.vn</a>, xúc phạm đến người  khác, vi phạm pháp luật…).</li>
                                        <li>Thành  viên sau khi đăng ký phải có trách nhiệm tự quản lý tài khoản và mật khẩu. Nếu  thành viên không quản lý tốt để người thứ ba lấy được tài khoản, chúng tôi sẽ không chịu trách nhiệm về bất cứ những tổn thất phát sinh  do việc để mất tài khoản  gây ra.Trong trường hợp mất  tài khoản, bạn phải báo với chúng tôi để được giải quyết kịp thời.</li>
                                        <li>Nếu  bạn quên mật khẩu bạn có thể <a class="menu" href="./contact">liên hệ</a> với bộ phận kỹ thuật để được giải quyết cấp  mới mật khẩu. Trong trường hợp bạn quên cả tên tài khoản lẫn mật khẩu, chúng  tôi sẽ căn cứ vào những thông tin mà bạn cung cấp có phù hợp với thông tin mà bạn  đã đăng ký trên <a class="menu" href="./">mua3s.vn</a> hay không.</li>
                                        <li>Nếu  tài khoản của bạn hết thời hạn sử dụng chúng tôi sẽ khóa tài khoản của bạn . Nếu  bạn muốn sử dụng tiếp tài khoản của mình, bạn có thể <a class="menu" href="./contact">liên hệ</a> với chúng tôi để  được hướng dẫn.</li>
                                        <li>Những  thông tin của bạn sẽ được bảo mật và chúng tôi sẽ không sử dụng những thông tin  đó khi không được sự cho phép của bạn.</li>
                                        <li>Trong  trường hợp bạn không muốn sử dụng tài khoản của mình nữa, bạn có thể <a class="menu" href="./contact">liên hệ</a> với  chúng tôi để chúng tôi hủy bỏ tài khoản của bạn.</li>
                                    </ol>
                              <p><b>B. Những quy định khi tham gia vào  <a class="menu" href="./">mua3s.vn</a>:</b></p>
                                    <ol>
                                        <li>Tài  khoản của bạn được phép đăng sản phẩm, đăng tin rao vặt, đăng tin tuyển dụng,  đăng tin tìm việc.</li>
                                        <li>Những  tin đăng không đúng sự thật, không đúng quy định (thông tin cung cấp quá ít, nội  dung không rõ ràng, sử dụng từ ngữ kém văn hóa, vi phạm pháp luật…) sẽ bị xóa  mà không cần báo trước.</li>
                                        <li>Các  thành viên không được phép sử dụng <a class="menu" href="./">mua3s.vn</a> sai mục đích, không được lợi  dụng vào <a class="menu" href="./">mua3s.vn</a> để lừa đảo, thực hiện những hành vi vi phạm pháp luật,  gây tổn hại đến cá nhân hoặc công ty   khác.</li>
                                        <li>Các  thành viên không được gây tổn hại đến <a class="menu" href="./">mua3s.vn</a>, thực hiện những hành vi để  làm giảm uy tín của <a class="menu" href="./">mua3s.vn</a>.</li>
                                        <li>Trong  trường hợp có tranh chấp, khiếu nại các thành viên có thể <a class="menu" href="./contact">liên hệ</a> với chúng tôi  để được giải quyết thích đáng. Trong trường hợp chúng tôi không thể giải quyết  được thì chúng tôi sẽ đưa ra pháp luật để giải quyết.</li>
                                        <li>Chúng  tôi có toàn quyền quyết định để xử lý các thành viên nếu vi phạm những quy định  trên.</li>
                                    </ol>
                              <p><b>C. Những quyền lợi của thành viên VIP:</b></p>
                                    <ol>
                                        <li>Bạn  có quyền đăng sản phẩm, đăng tin rao vặt, đăng tin tuyển dụng, đăng tin tìm việc  trên <a class="menu" href="./">mua3s.vn</a>.</li>
                                        <li>Hệ  thống quản lý tài khoản của bạn được cung cấp thêm hai chức năng là quản lý sản  phẩm và quản lý khách mua hàng.</li>
                                        <li>Những sản phẩm, tin đăng của bạn sẽ được ưu tiên đưa lên hàng đầu.</li>
                                        <li>Những sản phẩm, tin đăng của bạn sẽ được <a class="menu" href="./">mua3s.vn</a> ưu tiên giới thiệu với khách  hàng.</li>
                                        <li>Tất  cả các thành viên VIP của <a class="menu" href="./">mua3s.vn</a> đều được chúng tôi ưu tiên trợ giúp  khi có yêu cầu.</li>
                                    </ol>
                              <p><b>D. Chi phí di trì tài khoản VIP trên  <a class="menu" href="./">mua3s.vn</a>:</b></p>
                              <blockquote>
                                    <font color="#004B7A">* 50.000  VNĐ/1 tháng.</font><br />
                                    <font color="#004B7A">* 200.000  VNĐ/6 tháng.</font><br />
                                    <font color="#004B7A">* 300.000  VNĐ/1 năm.</font><br />
                                    <font color="#004B7A" size="1"><i>(Đăng ký tối  thiểu 1 tháng)</i></font><br />
                              </blockquote>
                                    &nbsp;&nbsp;&nbsp;<font color="#FF0000">Mọi chi tiết  bạn có thể <a class="menu" href="./contact">liên hệ</a> với chúng tôi theo:</font><br />
                              <blockquote>
									<img src="'.base_url().'templates/home/images/phone_1.gif" border="0">&nbsp;<font color="#004B7A"><b>Điện thoại:</b> '.Setting::settingPhone.'</font><br>
									<img src="'.base_url().'templates/home/images/mobile_1.gif" border="0">&nbsp;<font color="#004B7A"><b><i>Hotline:</i></b> '.Setting::settingMobile.'</font><br>
                                    <a class="menu" href="mailto:'.Setting::settingEmail_1.'"><img src="'.base_url().'templates/home/images/mail.gif" border="0">&nbsp;'.Setting::settingEmail_1.'</a><br />
                                    <a class="menu" href="ymsgr:SendIM?'.Setting::settingYahoo_1.'"><img src="'.base_url().'templates/home/images/yahoo.gif" border="0">&nbsp;'.Setting::settingYahoo_1.'</a>
                              </blockquote>';
$lang['role_saler_defaults'] = '<b><i>Những quy định và quyền lợi của bạn khi bạn đăng ký cửa hàng trên <a class="menu" href="./">mua3s.vn</a>:</i></b>
                                <p><b>A. Những quy định về việc đăng ký và quản lý  tài khoản:</b></p>
                                    <ol>
                                        <li>Tài  khoản của bạn sau khi đăng ký chưa sử dụng được, để sử dụng tài khoản này bạn  vui lòng <a class="menu" href="./contact">liên hệ</a> với chúng tôi để được hướng dẫn chi tiết.</li>
                                        <li>Nếu  quá thời hạn 7 ngày sau khi đăng ký mà bạn không <a class="menu" href="./contact">liên hệ</a> với chúng tôi thì  chúng tôi sẽ xóa tài khoản này.</li>
                                        <li>Tài  khoản đăng ký, thông tin cá nhân của bạn phải hợp lệ (không được dùng các từ ngữ  thô tục, kém văn hóa, gây ảnh hưởng xấu đến <a class="menu" href="./">mua3s.vn</a>, xúc phạm đến người  khác, vi phạm pháp luật…).</li>
                                        <li>Thành  viên sau khi đăng ký phải có trách nhiệm tự quản lý tài khoản và mật khẩu. Nếu  thành viên không quản lý tốt để người thứ ba lấy được tài khoản, chúng tôi sẽ không chịu trách nhiệm về bất cứ những tổn thất phát sinh  do việc để mất tài khoản  gây ra.Trong trường hợp mất  tài khoản, bạn phải báo với chúng tôi để được giải quyết kịp thời.</li>
                                        <li>Nếu  bạn quên mật khẩu bạn có thể <a class="menu" href="./contact">liên hệ</a> với bộ phận kỹ thuật để được giải quyết cấp  mới mật khẩu. Trong trường hợp bạn quên cả tên tài khoản lẫn mật khẩu, chúng  tôi sẽ căn cứ vào những thông tin mà bạn cung cấp có phù hợp với thông tin mà bạn  đã đăng ký trên <a class="menu" href="./">mua3s.vn</a> hay không.</li>
                                        <li>Nếu  tài khoản của bạn hết thời hạn sử dụng chúng tôi sẽ khóa tài khoản và cửa hàng  của bạn. Nếu bạn muốn sử dụng tiếp tài khoản của mình, bạn có thể <a class="menu" href="./contact">liên hệ</a> với  chúng tôi để được hướng dẫn.</li>
                                        <li>Những  thông tin của bạn sẽ được bảo mật và chúng tôi sẽ không sử dụng những thông tin  đó khi không được sự cho phép của bạn.</li>
                                        <li>Trong  trường hợp bạn không muốn sử dụng tài khoản của mình nữa, bạn có thể <a class="menu" href="./contact">liên hệ</a> với  chúng tôi để chúng tôi hủy bỏ tài khoản của bạn.</li>
                                    </ol>
                                <p><b>B. Những quy định khi tham gia vào  <a class="menu" href="./">mua3s.vn</a>:</b></p>
                                    <ol>
                                        <li>Tài  khoản của bạn được phép đăng sản phẩm, đăng tin rao vặt, đăng tin tuyển dụng,  đăng tin tìm việc.</li>
                                        <li>Những  tin đăng không đúng sự thật, không đúng quy định (thông tin cung cấp quá ít, nội  dung không rõ ràng, sử dụng từ ngữ kém văn hóa, vi phạm pháp luật…) sẽ bị xóa  mà không cần báo trước.</li>
                                        <li>Các  cửa hàng không được phép sử dụng <a class="menu" href="./">mua3s.vn</a> sai mục đích, không được lợi dụng  vào <a class="menu" href="./">mua3s.vn</a> để lừa đảo, thực hiện những hành vi vi phạm pháp luật, gây tổn  hại đến cá nhân, cửa hàng hoặc công ty   khác.</li>
                                        <li>Các  cửa hàng không được gây tổn hại đến <a class="menu" href="./">mua3s.vn</a>, thực hiện những hành vi để  làm giảm uy tín của <a class="menu" href="./">mua3s.vn</a>.</li>
                                        <li>Trong  trường hợp có tranh chấp, khiếu nại các chủ cửa hàng có thể <a class="menu" href="./contact">liên hệ</a> với chúng  tôi để được giải quyết thích đáng. Trong trường hợp chúng tôi không thể giải quyết được thì chúng tôi sẽ đưa ra pháp luật để giải quyết.</li>
                                        <li>Chúng  tôi có toàn quyền quyết định để xử lý các cửa hàng nếu vi phạm những quy định  trên.</li>
                                    </ol>
                                <p><b>C. Những quy định khi mở cửa hàng trên <a class="menu" href="./">mua3s.vn</a>:</b></p>
                                    <ol>
                                        <li>Bạn  phải cung cấp đây đủ thông tin mà chúng tôi yêu cầu (tên cửa hàng, địa chỉ, điện  thoại, logo…).</li>
                                        <li>Thông  tin về cửa hàng của bạn phải chính xác, đúng sự thật.</li>
                                        <li>Cửa  hàng của bạn vẫn còn đang hoạt động đúng pháp luật.</li>
                                        <li>Những  sản phẩm, tin đăng của bạn phải chính xác, đảm bảo chất lượng.</li>
                                        <li>Bạn  nên tuân theo một số quy ước khi đăng sản phẩm, tin rao vặt mà chúng tôi cung cấp  để đảm bảo sản phẩm, tin rao vặt của bạn hiển thị tốt trên <a class="menu" href="./">mua3s.vn</a>.</li>
                                        <li>Số  lượng sản phẩm của cửa hàng trên <a class="menu" href="./">mua3s.vn</a> phải trên 12 sản phẩm.</li>
                                        <li>Nếu có sự thay đổi về thông tin sản  phẩm, các cửa hàng phải kịp thời thay đổi để cho phù hợp với khả năng cung cấp sản phẩm  dịch vụ thực tế.</li>
                                        <li>Trong trường hợp cửa hàng đăng sản phẩm mới, thì phải đảm bảo sản  phẩm của mình đăng là  mới 100% (sản phẩm chưa sử dụng, vẫn còn thời gian bảo hành nếu  có… ).</li>
                                        <li>Cửa hàng chỉ nên đăng những sản phẩm có thể gởi cho khách hàng trong thời  gian 7 ngày khi có khách hàng yêu cầu.</li>
                                        <li>Cửa hàng phải có trách nhiệm làm đúng những gì đã cam kết với khách hàng.  Nếu khách hàng có khiếu nại về chất lượng, giá cả… của sản phẩm mà khách hàng  đã mua ở cửa hàng và chứng minh được đó là đúng sự thật thì cửa hàng phải có  trách nhiệm bồi thường cho khách hàng. Nếu cửa hàng không thực hiện đúng quy định  thì khách hàng có quyền khiếu nại với cơ quan chức năng có thẩm quyền và <a class="menu" href="./">mua3s.vn</a> sẽ không bảo trợ cho  cửa hàng.</li>
                                        <li>Nếu cửa hàng vi phạm những quy định trên thì chúng tôi sẽ xóa cửa hàng  mà không cần chịu bất cứ trách nhiệm, hay tổn thất nào của cửa hàng.</li>
                                    </ol>
                                <p><b>D. Những quyền lợi khi mở cửa hàng trên <a class="menu" href="./">mua3s.vn</a>:</b></p>
                                    <ol>
                                        <li>Bạn  sẽ được khởi tạo một cửa hàng dành riêng cho bạn.</li>
                                        <li>Hệ  thống quản lý của bạn được cung cấp đầy đủ các chức năng quản lý.</li>
                                        <li>Những  sản phẩm, tin đăng của bạn sẽ được ưu tiên đưa lên hàng đầu và được đưa vào mục <font color="#004B7A">sản phẩm tin cậy</font>, <font color="#004B7A">rao vặt tin cậy</font>.</li>
                                        <li>Những  sản phẩm, tin đăng của bạn sẽ được <a class="menu" href="./">mua3s.vn</a> ưu tiên giới thiệu với khách  hàng.</li>
                                        <li>Cửa hàng của bạn sẽ được đặt logo của cửa hàng và được quảng cáo trên <a class="menu" href="./">mua3s.vn</a>.</li>
                                        <li>Tất  cả các cửa hàng trên <a class="menu" href="./">mua3s.vn</a> đều được chúng tôi ưu tiên trợ giúp khi có  yêu cầu.</li>
                                    </ol>
                                <p><b>E. Chi phí di trì cửa hàng trên  <a class="menu" href="./">mua3s.vn</a>:</b></p>
                                    <blockquote>
										<font color="#004B7A">* 300.000 VNĐ/3  tháng.</font><br />
                                        <font color="#004B7A">* 500.000 VNĐ/6  tháng.</font><br />
                                        <font color="#004B7A">* 900.000  VNĐ/1 năm.</font><br />
                                        <font color="#004B7A" size="1"><i>(Đăng ký tối thiểu 3 tháng)</i></font><br />
                                    </blockquote>
                                    &nbsp;&nbsp;&nbsp;<font color="#FF0000">Mọi chi tiết  bạn có thể <a class="menu" href="./contact">liên hệ</a> với chúng tôi theo:</font><br />
                                    <blockquote>
                                        <img src="'.base_url().'templates/home/images/phone_1.gif" border="0">&nbsp;<font color="#004B7A"><b>Điện thoại:</b> '.Setting::settingPhone.'</font><br>
										<img src="'.base_url().'templates/home/images/mobile_1.gif" border="0">&nbsp;<font color="#004B7A"><b><i>Hotline:</i></b> '.Setting::settingMobile.'</font><br>
										<a class="menu" href="mailto:'.Setting::settingEmail_1.'"><img src="'.base_url().'templates/home/images/mail.gif" border="0">&nbsp;'.Setting::settingEmail_1.'</a><br />
										<a class="menu" href="ymsgr:SendIM?'.Setting::settingYahoo_1.'"><img src="'.base_url().'templates/home/images/yahoo.gif" border="0">&nbsp;'.Setting::settingYahoo_1.'</a>
                                    </blockquote>';
$lang['username_regis_label_defaults'] = 'Tài khoản';
$lang['password_regis_label_defaults'] = 'Mật khẩu';
$lang['repassword_regis_label_defaults'] = 'Mật khẩu xác nhận';
$lang['email_regis_label_defaults'] = 'Email';
$lang['reemail_regis_label_defaults'] = 'Email xác nhận';
$lang['fullname_regis_label_defaults'] = 'Họ tên';
$lang['address_regis_label_defaults'] = 'Địa chỉ';
$lang['province_regis_label_defaults'] = 'Tỉnh / Thành phố';
$lang['phone_regis_label_defaults'] = 'Điện thoại';
$lang['mobile_regis_label_defaults'] = 'Điện thoại thứ 2';
$lang['yahoo_regis_label_defaults'] = 'Nick Yahoo';
$lang['skype_regis_label_defaults'] = 'Nick Skype';
$lang['captcha_regis_label_defaults'] = 'Mã xác nhận';
$lang['_exist_username_message_defaults'] = 'Tài khoản này đã được sử dụng';
$lang['_exist_email_message_defaults'] = 'Email này đã được sử dụng';
$lang['_valid_captcha_message_defaults'] = '%s không đúng';
$lang['useragent_defaults'] = 'mua3s.vn';
$lang['subject_send_mail_defaults'] = 'mua3s.vn - Đăng Ký Thành Viên';
$lang['welcome_site_defaults'] = '<b><font color="#FF0000">Chào mừng bạn đến với</font> <a href="'.base_url().'" title="'.base_url().'">mua3s.vn</a></b><br><br>';
$lang['mail_activation_defaults'] = 'Bạn đã đăng ký thành công tài khoản trên <a href="'.base_url().'" title="'.base_url().'">mua3s.vn</a>. Nếu bạn đăng ký tài khoản <font color="#FF0000"><b>VIP</b></font> hoặc <font color="#FF0000"><b>Cửa hàng ảo</b></font>, bạn vui lòng liên hệ với chúng tôi theo:<br>&bull; <b>Điện thoại:</b> '.Setting::settingPhone.'<br>&bull; <b>Email:</b> '.Setting::settingEmail_1.'<br>&bull; <b>Địa chỉ:</b> '.Setting::settingAddress_1.'<br>Nếu bạn đăng ký tài khoản bình thường, bạn vui lòng copy hoặc nhấp vào đường link bên dưới để kích hoạt tài khoản.<br><i>Chúc bạn thành công!</i><br><br>';
$lang['success_register_defaults'] = 'Tài khoản của bạn đã được đăng ký thành công.<br>Nếu bạn đăng ký thành viên <font color="#FF0000">VIP</font> hoặc <font color="#FF0000">Cửa hàng ảo</font>, bạn vui lòng liên hệ với chúng tôi để được hướng dẫn kích hoạt.';
$lang['success_register_not_send_activation_defaults'] = '<font color="#FF0000">Email kích hoạt tài khoản không thể gởi tới Email mà bạn đã đăng ký</font>. Bạn vui lòng liên hệ với chúng tôi để được hỗ trợ.';
$lang['success_register_success_send_activation_defaults'] = 'Nếu bạn đăng ký tài khoản bình thường, bạn vui lòng kiểm tra Email để kích hoạt tài khoản.';
$lang['success_normal_defaults'] = 'Nếu bạn đăng ký tài khoản bình thường, ngay bây giờ bạn có thể sử dụng tài khoản của mình trên <a class="menu" href="'.base_url().'" title="'.base_url().'">mua3s.vn</a>.';
#END Defaults
#BEGIN: Activation
$lang['title_activation'] = 'KÍCH HOẠT TÀI KHOẢN';
$lang['success_activation'] = 'Tài khoản của bạn đã được kích hoạt thành công.<br>Ngay bây giờ bạn có thể sử dụng tài khoản của bạn trên <a class="menu" href="'.base_url().'">mua3s.vn</a>. Mọi thắc mắc bạn có thể liên hệ với chúng tôi để được hỗ trợ.';
$lang['vip_or_saler_activation'] = 'Tài khoản của bạn là tài khoản <font color="#FF0000">VIP</font> hoặc <font color="#FF0000">Cửa hàng ảo</font>. Bạn vui lòng liên hệ với chúng tôi để được hướng dẫn kích hoạt.';
$lang['error_activation'] = '<font color="#FF0000">Thông tin kích hoạt tài khoản không đúng.</font><br>Bạn vui lòng thử lại hoặc liên hệ với chúng tôi để được hỗ trợ.';
#END Activation