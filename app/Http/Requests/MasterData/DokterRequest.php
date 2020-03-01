<?php

    namespace App\Http\Requests\MasterData;

    use App\Http\Requests\Request;
    use Illuminate\Contracts\Validation\Validator;

    /**
     * Class DataPemdaFormRequest
     * @package App\Http\Requests\DataUmum
     */
    class DokterRequest extends Request
    {
        public function authorize()
        {
            return true;
        }

        /**
         * @var array
         */
        protected $attrs = [
            'nik'              => 'NIK',
            'nama_dokter'             => 'Nama',
            'alamat'           => 'Alamat',
            'tempat_lahir'     => 'Tempat Lahir',
            'tgl_lahir'        => 'Tanggal Lahir',
            'spesialis_id'     => 'Spesialis',
            'subspesialis_id' => 'Sub Spesialis',
            'no_telp'          => 'Nomer Telepon',
        ];

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            return [
                'nik'              => 'required|numeric',
                'nama_dokter'             => 'required',
                'alamat'           => 'required',
                'tempat_lahir'     => 'required',
                'tgl_lahir'        => 'required',
                'spesialis_id'     => 'required',
                'subspesialis_id' => 'required',
                'no_telp'          => 'required|numeric',
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
                    'nik'              => $message->first('nik'),
                    'nama_dokter'      => $message->first('nama_dokter'),
                    'alamat'           => $message->first('alamat'),
                    'tempat_lahir'     => $message->first('tempat_lahir'),
                    'tgl_lahir'        => $message->first('tgl_lahir'),
                    'spesialis_id'     => $message->first('spesialis_id'),
                    'subspesialis_id' => $message->first('subspesialis_id'),
                    'no_telp'          => $message->first('no_telp'),
                ]
            ];
        }
    }
