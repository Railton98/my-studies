"use client";

import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { AlertCircle } from "lucide-react";

interface GoalFormProps {
  onSubmit: (title: string, endDate: string) => void;
  onCancel: () => void;
  isLoading?: boolean;
}

/**
 * Form component for adding a new goal
 * Includes title input, date picker, validation, and error display
 */
export function GoalForm({
  onSubmit,
  onCancel,
  isLoading = false,
}: GoalFormProps) {
  const [title, setTitle] = useState("");
  const [endDate, setEndDate] = useState("");
  const [errors, setErrors] = useState<{ title?: string; date?: string }>({});

  // Get today's date in YYYY-MM-DD format for minimum date
  const today = new Date().toISOString().split("T")[0];

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setErrors({});

    // Validate form
    const newErrors: { title?: string; date?: string } = {};

    if (!title.trim()) {
      newErrors.title = "Title is required";
    }

    if (!endDate) {
      newErrors.date = "End date is required";
    }

    if (Object.keys(newErrors).length > 0) {
      setErrors(newErrors);
      return;
    }

    onSubmit(title, endDate);
    setTitle("");
    setEndDate("");
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      {/* Title input */}
      <div>
        <label htmlFor="title" className="block text-sm font-medium text-gray-900">
          Goal Title
        </label>
        <Input
          id="title"
          type="text"
          placeholder="e.g., Complete project report"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          disabled={isLoading}
          className="mt-1 min-h-10"
        />
        {errors.title && (
          <p className="flex items-center gap-1 text-red-600 text-sm mt-1">
            <AlertCircle className="h-4 w-4" />
            {errors.title}
          </p>
        )}
      </div>

      {/* End date input */}
      <div>
        <label htmlFor="endDate" className="block text-sm font-medium text-gray-900">
          End Date
        </label>
        <Input
          id="endDate"
          type="date"
          value={endDate}
          onChange={(e) => setEndDate(e.target.value)}
          disabled={isLoading}
          min={today}
          className="mt-1 min-h-10"
        />
        {errors.date && (
          <p className="flex items-center gap-1 text-red-600 text-sm mt-1">
            <AlertCircle className="h-4 w-4" />
            {errors.date}
          </p>
        )}
      </div>

      {/* Action buttons */}
      <div className="flex gap-3 pt-4">
        <Button
          type="submit"
          disabled={isLoading}
          className="flex-1 bg-pastel-mint hover:bg-pastel-mint/80 text-gray-900 min-h-10"
        >
          {isLoading ? "Adding..." : "Add Goal"}
        </Button>
        <Button
          type="button"
          variant="outline"
          onClick={onCancel}
          disabled={isLoading}
          className="flex-1 min-h-10"
        >
          Cancel
        </Button>
      </div>
    </form>
  );
}
