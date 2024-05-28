import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import { useForm } from "@inertiajs/react";
import Feature from "@/Components/Feature.jsx";

export default  function Index({ feature, answer }){
    const { data, setData, post, reset, errors, processing } = useForm({
        number1:"",
        number2:"",
    });

    const submit = (e)=> {
        e.preventDefault();
        post(route('feature1.calculate'), {
            onSuccess(){
               reset();
            },
        });
    };
    console.log("Frome Feature1/Index component => " +answer)
    return(
        <Feature feature={feature} answer={answer}>
            <form onSubmit={submit} className="pl-8 pr-8 grid grid-cols-2 gap-3">
                <div>
                    <InputLabel htmlFor="number1" value="Nombre 1"/>

                    <TextInput id="number1" type="text" name="number1" value={data.number1} className="mt-1 block w-full" onChange={(e)=>setData("number1",e.target.value)} />
                    <InputError message={errors.number1} className="mt-2"/>
                </div>
                <div>
                    <InputLabel htmlFor="number2" value='Nombre 2'/>

                    <TextInput id='number2' type='text' name="number2" value={data.number2} className="mt-1 block w-full" onChange={(e)=>setData("number2",e.target.value)} />
                    <InputError message={errors.number2} className="mt-2"/>
                </div>
                <div className="flex items-center justify-end pb-8 mt-4 col-span-2">
                    <PrimaryButton className="ms-4" disabled={processing}>
                        Calculer
                    </PrimaryButton>
                </div>
            </form>
        </Feature>
    );
}
