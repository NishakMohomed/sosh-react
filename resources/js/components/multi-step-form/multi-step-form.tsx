import { StepOneForm } from '@/components/multi-step-form/step-one-form';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Progress } from '@/components/ui/progress';
import { useState } from 'react';

export const MultiStepForm = () => {
    const [currentStep, setCurrentStep] = useState<number>(1);
    const [formData, setFormData] = useState({
        url: '',
        // Any other fields(questions)
    });

    const handleNextStep = (data: any) => {
        setFormData((prev) => ({
            ...prev,
            ...data,
        }));

        setCurrentStep(currentStep + 1);
    };

    const handlePreviousStep = () => {
        setCurrentStep(currentStep - 1);
    };

    const progressValue = (currentStep / 3) * 100;

    const currentStepHeading = () => {
        switch (currentStep) {
            case 1:
                return "Let's create your new post";

            case 2:
                return 'Step 2 - Question';

            case 3:
                return 'Step 3 - Question';

            default:
                return '';
        }
    };

    return (
        <div className="mx-auto h-full w-full max-w-3xl">
            <Card className="mx-auto max-w-3xl">
                <CardHeader>
                    <CardTitle className="text-2xl">
                        {currentStepHeading()}
                    </CardTitle>
                    <CardDescription>
                        <Progress value={progressValue} className="h-2" />
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    {currentStep === 1 && (
                        <StepOneForm onNext={handleNextStep} />
                    )}
                </CardContent>
            </Card>
        </div>
    );
};
