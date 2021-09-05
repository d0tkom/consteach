<template>
	<div>
		<div v-if="$root.popup.registrationType" class="slideoutContent p-6">
			<c-btn
				class="slideoutCloseBtn"
				icon="close"
				icon-only
				text
				circle
				@click="$root.hideRegistrationPopup()"
			></c-btn>

			<div class="flex justify-center my-4 mb-8">
				<logo
					class="brandLogo"
					:width="200"
					:height="60"
				/>
			</div>

	        <jet-validation-errors class="mb-4" />

			<div class="roleSelect grid grid-cols-2 gap-4 mb-8">
				<c-btn
					full
					:outlined="form.teacher"
					@click="form.teacher = false"
				>{{ trans.get('auth.register_as_student') }}</c-btn>
				<c-btn
					full
					:outlined="!form.teacher"
					@click="form.teacher = true"
				>{{ trans.get('auth.register_as_teacher') }}</c-btn>
			</div>
			
			<div class="socialLogin">
				<a :href="'/login/facebook?teacher='+form.teacher">
					<c-btn
						class="mb-4"
						full
						color="facebook"
						icon="facebook"
					>{{ trans.get('auth.login_with_facebook_btn') }}</c-btn>
				</a>
				
				<a :href="'/login/google?teacher='+form.teacher">
					<c-btn
						full
						outlined
					>
						<div class="flex items-center">
							<div class="googleIconContainer mr-4">
								<img src="/img/google_logo.svg" alt="Google logo">
							</div>
							<span>{{ trans.get('auth.login_with_google_btn') }}</span>
						</div>
					</c-btn>
				</a>
			</div>
			
			<div class="hr">{{ trans.get('auth.login_social_or_email') }}</div>
			
	        <form @submit.prevent="submit">
	            <div class="grid grid-cols-2 gap-4 mb-4">
	                <c-input
		                :label="trans.get('auth.first_name_label')"
		                id="first_name"
		                type="text"
		                v-model="form.first_name"
		                required
		                autofocus
		                autocomplete="first_name"
	                />
		
		            <c-input
			            :label="trans.get('auth.last_name_label')"
			            id="last_name"
			            type="text"
			            v-model="form.last_name"
			            required
			            autocomplete="last_name"
		            />
	            </div>

	            <div class="mb-4">
		            <c-input
			            :label="trans.get('auth.email_label')"
			            id="registration_email"
			            type="email"
			            v-model="form.email"
			            required
			            autocomplete="email"
		            />
	            </div>
		
		        <div class="grid grid-cols-2 gap-4 mb-4">
		            <c-input
			            :label="trans.get('auth.password_label')"
			            id="registration_password"
			            type="password"
			            v-model="form.password"
			            required
			            autocomplete="password"
		            />
			        <c-input
				        :label="trans.get('auth.password_confirmation_label')"
				        id="registration_password_confirmation"
				        type="password"
				        v-model="form.password_confirmation"
				        required
				        autocomplete="password_confirmation"
			        />
	            </div>
	            <div class="mb-4">
	                <jet-label for="terms">
	                    <div class="flex items-center">
	                        <c-checkbox
		                        class="my-2 flex items-start"
		                        v-model="form.terms"
		                        :error="!!$page.props.errors.terms"
	                        >
		                        {{ trans.get('auth.privacy_part_1') }} <a href="/terms_and_conditions.pdf" target="_blank" style="color: #18A0FB">{{ trans.get('auth.terms') }}</a> {{ trans.get('auth.privacy_part_2') }} <a href="/privacy_policy.pdf" target="_blank" style="color: #18A0FB">{{ trans.get('auth.privacy') }}</a>.
	                        </c-checkbox>
	                    </div>
	                </jet-label>
	            </div>

	            <div class="flex items-center justify-center my-4">
	                <c-btn
		                :loading="form.processing"
		                @click="submit"
	                >
		                {{ trans.get('auth.register_btn') }}
	                </c-btn>
	            </div>
		        
		        <div class="flex justify-end">
			        <c-btn
				        @click="$root.openLoginPopup()"
				        text
				    >
				        {{ trans.get('auth.already_registered_btn') }}
			        </c-btn>
		        </div>
	        </form>
	    </div>
	    <div v-else class="slideoutContent p-6">
	    	<c-btn
				class="slideoutCloseBtn"
				icon="close"
				icon-only
				text
				circle
				@click="$root.hideRegistrationPopup()"
			></c-btn>
			<div class="pt-10">
				<div class="teacherWidgetMainCard listPage boughtEvent card p-sm blue-border">
					<div class="flex flex-col text-center" @click="form.teacher = false; $root.popup.registrationType = 'teacher'">
						<p>{{ trans.get('auth.register_as_student') }}</p>
						<div class="m-auto">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="148" height="148" fill="none" xmlns:v="https://vecta.io/nano"><path d="M33.22 17.08h109.099v66.034H33.22V17.08z" fill="#d2e2f2"/><path opacity=".002" d="M142.325 17.083v66.031H33.231V69.879h50.747c24.904 0 45.112-20.208 45.112-45.14v-7.656h13.235z" fill="#000"/><g fill="#ffb564"><path d="M88.418 43.125v5.237c0 2.049-1.651 3.7-3.7 3.7H56.797c-2.675 0-4.839 2.163-4.839 4.838v62.815c0 2.96-2.419 5.379-5.379 5.379H23.725a5.39 5.39 0 0 1-5.379-5.35V89.432H9.38c-2.021 0-3.7-1.651-3.7-3.728V50.724c0-6.262 5.066-11.271 11.271-11.271h67.796c2.021 0 3.671 1.622 3.671 3.672h0z"/><use xlink:href="#B"/><use xlink:href="#B"/></g><path opacity=".002" d="M46.011 18.677c0 7.172-5.721 17.874-12.779 17.874-3.586 0-6.831-2.761-9.136-6.432.939.398 1.907.626 2.903.626 7.058 0 12.779-10.701 12.779-17.874a13.31 13.31 0 0 0-1.48-6.119c4.525 1.992 7.713 6.575 7.713 11.925h0z" fill="#000"/><use xlink:href="#C" fill="#fff"/><path opacity=".003" d="M142.32 119.541a22.77 22.77 0 0 1-22.768 22.768c-7.34 0-13.863-3.461-18.02-8.853 3.861 3.009 8.714 4.783 13.967 4.783 12.558 0 22.751-10.192 22.751-22.75 0-5.288-1.809-10.141-4.818-14.002a22.71 22.71 0 0 1 8.888 18.054z" fill="#000"/><path d="M104.438 135.088c3.863 6.392 10.518 6.01 17.292 4.285 4.505-1.147 11.832-2.352 15.399-5.449.219-.191.452-.308.674-.478-3.028-4.832-7.865-8.358-13.534-9.627 2.68-1.611 4.492-4.518 4.492-7.872 0-5.088-4.124-9.212-9.211-9.212s-9.212 4.124-9.212 9.212c0 3.354 1.811 6.26 4.49 7.871-3.536.79-6.771 2.429-9.431 4.744a21.64 21.64 0 0 0-3.354 3.712c.872.769 1.697 1.658 2.395 2.814h0z" fill="#59de9b"/><path opacity=".01" d="M124.635 116.337c0 3.355-1.811 6.261-4.492 7.872a21.58 21.58 0 0 1 14.505 11.299c.927-.472 1.789-.984 2.481-1.584.22-.19.452-.308.674-.478-3.028-4.832-7.865-8.358-13.534-9.627 2.68-1.611 4.492-4.518 4.492-7.872 0-5.088-4.124-9.212-9.211-9.212-1.023 0-1.988.206-2.907.514 4.505.602 7.992 4.418 7.992 9.088h0z" fill="#231f20"/><use xlink:href="#C" x="-45.538" fill="#fff"/><path opacity=".003" d="M96.782 119.541a22.77 22.77 0 0 1-22.768 22.768c-7.34 0-13.863-3.461-18.02-8.853 3.861 3.009 8.714 4.783 13.967 4.783 12.558 0 22.751-10.192 22.751-22.75 0-5.288-1.809-10.141-4.818-14.002 5.41 4.157 8.888 10.697 8.888 18.054z" fill="#000"/><path d="M78.731 123.819c2.68-1.611 4.492-4.518 4.492-7.872 0-5.088-4.124-9.212-9.211-9.212s-9.211 4.124-9.211 9.212c0 3.354 1.811 6.26 4.49 7.871-3.537.79-6.772 2.429-9.431 4.744-1.85 1.611-3.377 3.567-4.593 5.73 1.012.849 1.953 1.75 2.806 2.85.876 1.128 1.715 2.279 2.561 3.427l13.136 1.214c6.468-.192 12.33-2.473 17.288-6.792.484-.422.988-.733 1.49-1.06-3.002-5.079-7.961-8.802-13.816-10.112h0z" fill="#ff5975"/><path opacity=".01" d="M79.097 116.337c0 3.355-1.812 6.261-4.492 7.872 6.584 1.474 12.074 5.967 14.867 12.052.536-.405 1.068-.82 1.585-1.27.484-.422.988-.733 1.49-1.06-3.002-5.079-7.961-8.802-13.816-10.112 2.68-1.611 4.492-4.518 4.492-7.872 0-5.088-4.124-9.212-9.211-9.212-1.022 0-1.988.206-2.907.514 4.505.602 7.993 4.418 7.993 9.088z" fill="#231f20"/><use xlink:href="#C" x="-91.077" fill="#fff"/><path opacity=".003" d="M51.243 119.541a22.77 22.77 0 0 1-22.768 22.768c-7.34 0-13.863-3.461-18.02-8.853 3.861 3.009 8.714 4.783 13.967 4.783 12.558 0 22.751-10.192 22.751-22.75 0-5.288-1.809-10.141-4.818-14.002 5.41 4.157 8.888 10.697 8.888 18.054h0z" fill="#000"/><path d="M13.383 137.808l1.68.99c4.092 1.741 8.907 1.947 13.28 1.974 4.974.031 14.269.826 17.162-4.261.501-.881 1.07-1.624 1.676-2.283-2.98-5.233-8.02-9.073-13.989-10.409 2.68-1.611 4.492-4.518 4.492-7.872 0-5.088-4.124-9.212-9.211-9.212s-9.211 4.124-9.211 9.212c0 3.354 1.811 6.26 4.49 7.871-3.536.789-6.772 2.429-9.431 4.744-1.445 1.258-2.72 2.709-3.79 4.313l2.853 4.933h0z" fill="#828fff"/><path opacity=".01" d="M33.559 116.337c0 3.355-1.812 6.261-4.492 7.872 7.094 1.588 12.893 6.694 15.437 13.509.365-.373.736-.74 1.001-1.207.501-.881 1.07-1.624 1.676-2.283-2.98-5.233-8.02-9.073-13.989-10.409 2.68-1.611 4.492-4.518 4.492-7.872 0-5.088-4.124-9.212-9.211-9.212-1.022 0-1.988.206-2.907.514 4.505.602 7.993 4.418 7.993 9.088h0z" fill="#231f20"/><path d="M142.32 85.959c1.572 0 2.846-1.274 2.846-2.846V17.079c0-1.572-1.274-2.846-2.846-2.846l-94.111.003C46.307 7.665 40.313 2.848 33.221 2.848c-8.616 0-15.626 7.102-15.626 15.83 0 5.902 3.294 13.802 8.426 17.929h-9.071c-7.784 0-14.117 6.333-14.117 14.117v34.979a6.57 6.57 0 0 0 6.547 6.575H15.5v5.213c-7.551 4.46-12.641 12.661-12.641 22.047 0 14.123 11.49 25.613 25.614 25.613 9.915 0 18.514-5.674 22.769-13.935 4.255 8.261 12.854 13.935 22.769 13.935s18.514-5.674 22.769-13.935c4.256 8.261 12.854 13.935 22.77 13.935 14.123 0 25.614-11.49 25.614-25.613s-11.491-25.614-25.614-25.614c-9.916 0-18.514 5.674-22.77 13.936-4.255-8.262-12.854-13.936-22.769-13.936-7.65 0-14.509 3.389-19.206 8.724v-16.69h87.515 0zM23.288 18.679c0-5.589 4.457-10.138 9.934-10.138s9.932 4.549 9.932 10.138c0 6.282-5.004 15.02-9.932 15.02s-9.934-8.739-9.934-15.02h0zm25.499 1.25l90.687-.003v60.342H54.805V56.9c0-1.099.894-1.993 1.992-1.993h27.921c3.611 0 6.547-2.937 6.547-6.546v-5.236a6.53 6.53 0 0 0-6.518-6.518H40.42c4.779-3.844 7.953-10.95 8.367-16.679h0zM21.192 89.493c.001-.027.015-.049.015-.076v-23.8c0-1.572-1.274-2.846-2.846-2.846s-2.846 1.274-2.846 2.846v20.969H9.381c-.471 0-.855-.396-.855-.882V50.724c0-4.646 3.779-8.425 8.425-8.425h67.796c.463 0 .826.363.826.826v5.236c0 .478-.375.853-.855.853H56.797c-4.237 0-7.684 3.448-7.684 7.685v47.535c-4.665-6.358-12.168-10.51-20.64-10.51-2.53 0-4.971.382-7.281 1.069v-5.502zm7.281 49.967c-10.984 0-19.922-8.936-19.922-19.921s8.937-19.921 19.922-19.921 19.922 8.937 19.922 19.921-8.937 19.921-19.922 19.921zm91.077-39.842c10.984 0 19.921 8.937 19.921 19.921s-8.937 19.921-19.921 19.921-19.922-8.936-19.922-19.921 8.937-19.921 19.922-19.921zm-45.539 0c10.984 0 19.922 8.937 19.922 19.921s-8.937 19.921-19.922 19.921-19.922-8.936-19.922-19.921 8.937-19.921 19.922-19.921z" fill="#293c66"/><defs ><path id="B" d="M20.442 18.679c0 7.171 5.721 17.866 12.779 17.866S46 25.851 46 18.679 40.279 5.694 33.221 5.694s-12.779 5.814-12.779 12.985h0z"/><path id="C" d="M119.55 142.305a22.77 22.77 0 0 0 22.766-22.766 22.77 22.77 0 0 0-22.766-22.767 22.77 22.77 0 0 0-22.766 22.767 22.77 22.77 0 0 0 22.766 22.766z"/></defs></svg>
						</div>
					</div>
				</div>
				
				<div class="teacherWidgetMainCard listPage boughtEvent card p-sm blue-border">
					<div class="flex flex-col text-center" @click="form.teacher = true; $root.popup.registrationType = 'student'">
						<p>{{ trans.get('auth.register_as_teacher') }}</p>
						<div class="m-auto">
							<svg xmlns="http://www.w3.org/2000/svg" width="162" height="162" fill="none" xmlns:v="https://vecta.io/nano"><path d="M142.102 155.022l-4.756-29.768c-1.976-6.526-7.841-11.451-14.982-12.697-28.242-4.924-55.273-4.924-83.515 0-7.14 1.246-12.942 6.171-14.918 12.697l-4.807 29.768h122.979z" fill="#2fcbff"/><path opacity=".002" d="M142.09 155.007H19.115l1.971-12.011h71.928c15.764 0 27.777-14.076 25.29-29.653v-.094c-.141-.516-.328-1.032-.61-1.501l4.692.797c7.132 1.267 12.997 6.194 14.967 12.716l4.739 29.746z" fill="#000"/><path d="M96.099 93.498v18.76c0 4.539-3.21 8.469-7.661 9.356-5.319 1.059-10.654 1.034-15.991-.102-4.29-.913-7.29-4.824-7.29-9.21V93.498a4.72 4.72 0 0 1 4.682-4.682h21.579a4.7 4.7 0 0 1 4.682 4.682h0z" fill="#ffb564"/><path d="M80.596 31.485c-15.091 0-27.314 16.298-27.314 36.474s12.256 36.474 27.314 36.474c15.124 0 27.347-16.298 27.347-36.474S95.688 31.485 80.596 31.485h0z" fill="#ffbc74"/><path opacity=".002" d="M107.946 67.973c0 20.17-12.229 36.445-27.349 36.445-8.062 0-15.302-4.654-20.322-12.077 3.56 2.282 7.545 3.559 11.773 3.559 15.12 0 27.349-16.306 27.349-36.476 0-9.37-2.647-17.888-6.936-24.338 9.157 5.871 15.484 18.375 15.484 32.886z" fill="#000"/><path d="M127.136 56.769a5.68 5.68 0 0 0 5.677-5.677 5.68 5.68 0 0 0-5.677-5.677 5.68 5.68 0 0 0-5.677 5.677 5.68 5.68 0 0 0 5.677 5.677z" fill="#828fff"/><path opacity=".002" d="M132.804 51.1c0 3.135-2.534 5.669-5.669 5.669-2.403 0-4.441-1.489-5.277-3.605a5.38 5.38 0 0 0 2.064.392c3.135 0 5.668-2.56 5.668-5.695 0-.731-.13-1.437-.391-2.063 2.116.836 3.605 2.899 3.605 5.303z" fill="#000"/><path d="M132.812 28.093L80.578 47.151 28.4 28.093 80.578 6.202l52.234 21.891z" fill="#52cc89"/><path opacity=".002" d="M106.851 37.551v-.852s-11.743-7.24-26.254-7.24-26.224 7.24-26.224 7.24v.882L28.393 28.09l15.698-6.571 10.283 3.377s11.712-7.24 26.224-7.24 26.254 7.24 26.254 7.24l10.252-3.377 15.698 6.571-25.95 9.461z" fill="#000"/><path d="M106.864 36.695v20.793h-.024s-11.741-7.204-26.242-7.204c-14.034 0-25.494 6.759-26.219 7.18V36.695s11.718-7.227 26.219-7.227 26.266 7.227 26.266 7.227h0z" fill="#51d690"/><path opacity=".002" d="M106.856 36.687V57.48h-.023c-.725-.421-12.186-7.204-26.219-7.204-14.057 0-25.518 6.783-26.219 7.204h-.023v-7.204h.023c.702-.421 12.162-7.204 26.219-7.204 2.713 0 5.356.257 7.812.678 5.122.842 9.777-3.134 9.777-8.327v-2.69c5.309 1.895 8.654 3.953 8.654 3.953z" fill="#000"/><path d="M140.408 124.765a3.2 3.2 0 0 0-.093-.41c-2.295-7.577-9.132-13.407-17.419-14.853-8.041-1.402-15.89-2.336-23.695-2.938v-7.35c7.188-7.245 11.841-18.545 11.841-31.256 0-3.59-.402-7.052-1.1-10.358.001-.039.022-.072.022-.112V39.73l14.845-5.416v9.97c-2.84.974-4.898 3.641-4.898 6.808 0 3.985 3.239 7.227 7.224 7.227a7.24 7.24 0 0 0 7.227-7.227c0-3.166-2.061-5.834-4.902-6.808V32.617l4.415-1.611a3.1 3.1 0 0 0 2.037-2.84c.031-1.275-.726-2.439-1.901-2.932L81.776 3.341c-.769-.321-1.629-.322-2.398.002L27.201 25.234a3.1 3.1 0 0 0-1.902 2.932c.03 1.275.839 2.403 2.038 2.84l23.941 8.744v17.714c0 .031.011.06.012.091-.703 3.319-1.108 6.797-1.108 10.403 0 12.738 4.669 24.058 11.875 31.301v7.302c-7.821.6-15.685 1.536-23.741 2.94-8.245 1.44-15.054 7.27-17.352 14.853a3.12 3.12 0 0 0-.094.404l-4.808 29.768c-.145.897.112 1.813.699 2.505s1.453 1.09 2.362 1.09h122.979a3.1 3.1 0 0 0 3.061-3.589l-4.754-29.768zm-9.146-73.674a4.13 4.13 0 0 1-4.127 4.127 4.13 4.13 0 0 1-4.124-4.127 4.13 4.13 0 0 1 4.124-4.125 4.13 4.13 0 0 1 4.127 4.125zm-73.784 1.337V38.521c3.455-1.798 12.571-5.953 23.12-5.953s19.699 4.156 23.165 5.957v13.908c-15.837-7.149-31.141-6.793-46.285-.006h0zM80.577 9.563l43.736 18.33-16.23 5.922c-2.219-1.286-13.569-7.448-27.485-7.448-13.953 0-25.286 6.194-27.462 7.46l-16.247-5.934 43.688-18.33zM56.382 67.958c0-2.95.303-5.797.834-8.518 15.208-8.024 31.517-8.04 46.795.022.529 2.714.83 5.555.83 8.496 0 18.403-10.875 33.374-24.246 33.374-13.352 0-24.213-14.971-24.213-33.374zm24.213 39.575c4.42 0 8.611-1.258 12.405-3.469v8.193a6.45 6.45 0 0 1-5.168 6.315 36.35 36.35 0 0 1-14.739-.092c-2.801-.598-4.835-3.196-4.835-6.179v-8.204c3.776 2.191 7.944 3.436 12.338 3.436zm-57.83 44.388l4.19-25.957c1.683-5.271 6.537-9.325 12.426-10.352 7.698-1.343 15.236-2.254 22.715-2.851.21 5.694 4.209 10.611 9.707 11.783a42.37 42.37 0 0 0 17.24.109c5.719-1.138 9.88-6.1 10.113-11.892 7.466.6 14.991 1.511 22.674 2.851 5.928 1.034 10.809 5.085 12.49 10.351l4.148 25.958H22.765h0z" fill="#293c66"/></svg>
						</div>
					</div>
				</div>
			</div>
	    </div>
	</div>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import Logo from "../../Layouts/Partials/Logo";

    export default {
        components: {
	        Logo,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },
        data() {
            return {
                form: this.$inertia.form({
	                teacher: this.$root.popup.registrationType === 'teacher',
                    first_name: '',
                    last_name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
	                availability_id: null,
	                teacher_id: null,
                })
            }
        },
	    watch: {
        	'$root.popup.registration'(registration) {
        		if (registration) {
        			this.form.teacher = this.$root.popup.registrationType === 'teacher';
		        }
	        }
	    },
        methods: {
            submit() {
        		if (this.$root.registrationAddonData) {
        			this.form.teacher_id = this.$root.registrationAddonData.teacher_id;
        			this.form.availability_id = this.$root.registrationAddonData.availability_id;
		        }
        		
                this.form.post(this.route('register'), {
	                onFinish: () => {
		                this.form.reset('password', 'password_confirmation');
	                },
					onSuccess: () => {
						this.$root.hideRegistrationPopup();
						this.$toast.success('Sikeres regisztráció');
						this.$root.registrationAddonData = null;
					},
					onError: error => {
						console.error(error);
						this.$toast.error('Sikertelen regisztráció');
					}
                })
            }
        }
    }
</script>
