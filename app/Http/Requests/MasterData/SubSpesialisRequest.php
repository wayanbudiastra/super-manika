<?php

    namespace App\Http\Requests\MasterData;

    use App\Http\Requests\Request;
    use Illuminate\Contracts\Validation\Validator;

    /**
     * Class DataPemdaFormRequest
     * @package App\Http\Requests\DataUmum
     */
    class SubSpesialisRequest extends Request
    {
        public function authorize()
        {
            return true;
        }

        /**
         * @var array
         */
        protected $attrs = [
            'nama_subspesialis' => 'Nama Spesialis',
            'keterangan'     => 'keterangan',
        ];

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            return [
                'nama_subspesialis' => 'required',
                'keterangan'     => '',
            ];
        }

        /**
         * @param $validator
         * @return mixed
         */
        public function validator($validator)
        {
            return $validator->make($this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attrs);
        }

        /**
         * @param Validator $validator
         * @return array
         */
        protected function formatErrors(Validator $validator)
        {
            $message = $validator->errors();

            return [
                'success'    => false,
                'validation' => [
                    'nama_subspesialis' => $message->first('nama_subspesialis'),
                    'keterangan'     => $message->first('keterangan'),
                ]
            ];
        }
    }
