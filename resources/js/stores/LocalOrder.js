import { defineStore} from 'pinia';
import {useForm} from "@inertiajs/inertia-vue3";

export const useLocalOrderStore = defineStore('localOrder',{
    state: () => {
        return {
            form : useForm(
                {
                    'title': '',
                    'academic_level_id': 2,
                    'subject_id': 1,
                    'service_type_id': 1,
                    'deadline': 336,
                    'pages': 1,
                    'slides': 0,
                    'sources': 1,
                    'instructions': '',
                    'referencing_style_id': 1,
                    'spacing_id': 1,
                    'writer_category_id': 1,
                    'discount_id': '',
                    'currency_id': 2,
                    'language_id': 1, 'extra': '',
                    'files': [],
                    'amount': '',
                    'name': '',
                    'email': '',
                    'password': '',
                    'password_confirmation': '',
                }
            ),
        }

    }
})
